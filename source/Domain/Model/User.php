<?php

namespace Source\Domain\Model;

use Source\Models\RecoverPassword;
use Source\Models\User as ModelsUser;

/**
 * User Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class User
{
    /** @var string Tipo de usuario */
    private $userType;

    /** @var string Login, email ou usuario */
    private $login;

    /** @var string */
    private $email;

    /** @var string Senha */
    private $password;

    /** @var ModelsUser */
    private $user;

    /**
     * Login constructor
     */
    public function __construct()
    {
        $this->user = new ModelsUser();
    }

    public function validateEmailFirstAccess(string $hashBase64) {
        
        if ($this->user instanceof ModelsUser) {
            $email = !empty($hashBase64) ? base64_decode($hashBase64) : '';
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
                return false;
            }
            
            $user = $this->user->find("full_email=:full_email", ":full_email=" . $email . "")->fetch();

            if (empty($user)) {
                return false;
            }
    
            $user->full_name = $user->full_name;
            $user->nick_name = $user->nick_name;
            $user->full_email = $user->full_email;
            $user->password_data = $user->password_data;
            $user->user_type = $user->user_type;
            $user->path_photo = $user->path_photo;
            $user->is_valid_user = 1;
            if (!$user->save()) {
                return false;
            }
    
            return true;
        }

    }

    public function login(string $login = '', string $email = '', string $password = '', string $userType = ''): bool
    {
        if (empty($this->login)) {
            $this->login = $login;
        }

        if (empty($this->email)) {
            $this->email = $email;
        }

        if (empty($this->password)) {
            $this->password = $password;
        }

        if (empty($this->userType)) {
            $this->userType = $userType;
        }

        if (!$this->validateUserType($this->userType)) {
            throw new \Exception('Invalid userType');
        }

        $user = $this->getUserByLogin($this->login, $this->email);

        if (empty($user)) {
            return false;
        }

        $user = $user->find('user_type=:user_type', ':user_type=' . $this->userType . '')->fetch();

        if (empty($user)) {
            return false;
        }

        if (!password_verify($this->password, $user->password)) {
            return false;
        }

        return true;
    }

    public function register(array $data)
    {
        if ($this->user instanceof ModelsUser) {

            $email = (new ModelsUser())
            ->find('full_email=:full_email', ':full_email=' . $data['email'] . '')
            ->fetch();

            if (!empty($email)) {
                echo json_encode(['email_already_exists' => true,
                "msg" => "E-mail já cadastrado"]);
                die;
            }

            if (!$this->checkParamsNotEmpty($data['fullName'], $data['email'], $data['userName'], $data['confirmPassword'], $data['userType'])) {
                return false;
            }

            if (!$this->validateUserType($data['userType'])) {
                return false;
            }

            $this->user->full_name = $data['fullName'];
            $this->user->full_email = $data['email'];
            $this->user->path_photo = $data['pathPhoto'];
            $this->user->nick_name = $data['userName'];
            $this->user->password_data = $data['confirmPassword'];
            $this->user->user_type = $data['userType'];
            $this->user->is_valid_user = 0;
            if (!$this->user->save()) {
                throw new \Exception($this->user->fail());
            }

            return true;
        }

        return false;
    }

    public function requestRecoverPassword(string $login, string $email): bool
    {
        $user = $this->getUserByLogin($login, $email);

        if (empty($user)) {
            return false;
        }

        $hash = md5(uniqid(rand(), true));
        $recoverPassword = new RecoverPassword();
        $recoverPassword->id_user = $user->id;
        $recoverPassword->nick_name = $user->login;
        $recoverPassword->full_email = $user->email;
        $recoverPassword->hash_data = $hash;
        $recoverPassword->is_valid = 1;
        $recoverPassword->expires_in = date('Y-m-d H:i:s', strtotime('+10 minute', time()));
        if (!$recoverPassword->save()) {
            throw new \Exception($recoverPassword->fail());
        }

        return true;
    }

    public function recoverPassword(string $login, string $email, string $newPassword, string $confirmPassword): bool
    {
        $user = $this->getUserByLogin($login, $email);

        if (empty($user)) {
            return false;
        }

        if ($newPassword != $confirmPassword) {
            return false;
        }

        $recover = $this->getRecoverPasswordByLogin($user->nick_name, $user->full_email);

        if (!$this->isValidHash($recover->hash_data)) {
            $recover->is_valid = 0;
        }

        if ($recover->is_valid) {
            $confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
            $user->password = $confirmPassword;
            if (!$user->save()) {
                throw new \Exception($user->fail());
            }

            $recover->is_valid = 0;
        }

        if (!$recover->save()) {
            throw new \Exception($recover->fail());
        }

        return true;
    }

    private function isValidHash(string $hash): bool
    {
        $recoverPassword = new RecoverPassword();
        $expires = $recoverPassword->find('hash_data=:hash_data', ':hash_data=' . $hash . '', 'expires_in')->fetch();

        if (empty($expires)) {
            throw new \Exception('invalid hash to recover password');
        }

        // Converter a $expires em um timestamp
        $expiresTimestamp = strtotime($expires->expires_in);
        return (time() > $expiresTimestamp) ? false : true;
    }

    /**
     * @param string $login
     * @param string $email
     * @return object|null
     */
    private function getRecoverPasswordByLogin(string $login, string $email)
    {
        $recoverPassword = new RecoverPassword();
        $recover = $recoverPassword->find('nick_name=:nick_name', ':nick_name=' . $login . '')->order('id', true)->fetch();

        if (empty($recover)) {
            $recoverPassword = new RecoverPassword();
            $recover = $recoverPassword->find('full_email=:full_email', ':full_email=' . $email . '')->order('id', true)->fetch();
        }

        return $recover;
    }

    /**
     * @param string $login
     * @param string $email
     * @return object|null
     */
    private function getUserByLogin(string $login = '', string $email = '')
    {
        if ($this->user instanceof ModelsUser) {
            $user = $this->user->find('nick_name=:nick_name', ':nick_name=' . $login . '')->fetch();

            if (empty($user)) {
                $this->user = new ModelsUser();
                $user = $this->user->find('full_email=:full_email', ':full_email=' . $email . '')->fetch();
            }

            return $user;
        }

        return null;
    }

    private function validateUserType(string $userType): bool
    {
        if ($userType == 'businessman' || $userType == 'designer') {
            return true;
        }
        return false;
    }

    private function checkParamsNotEmpty(...$args): bool
    {
        foreach ($args as $value) {
            if ($value == '') {
                return false;
            }
        }
        return true;
    }
}
