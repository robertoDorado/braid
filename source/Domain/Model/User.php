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
    public function __construct(string $login = '', string $email = '', string $password = '', string $userType = '')
    {
        $this->user = new ModelsUser();
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->userType = $userType;

        if ($this->userType != '') {
            if (!$this->validateUserType($this->userType)) {
                throw new \Exception('Invalid userType');
            }
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

    public function register(array $data): bool
    {
        if ($this->user instanceof ModelsUser) {

            if (!$this->checkParamsNotEmpty($data['fullName'], $data['email'], $data['userName'], $data['confirmPassword'], $data['userType'])) {
                return false;
            }

            if (!$this->validateUserType($data['userType'])) {
                return false;
            }

            $this->user->name = $data['fullName'];
            $this->user->email = $data['email'];
            $this->user->path_photo = $data['pathPhoto'];
            $this->user->user_name = $data['userName'];
            $this->user->password = $data['confirmPassword'];
            $this->user->user_type = $data['userType'];
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
        $recoverPassword->user = $user->login;
        $recoverPassword->email = $user->email;
        $recoverPassword->hash = $hash;
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

        $recover = $this->getRecoverPasswordByLogin($user->login, $user->email);

        if (!$this->isValidHash($recover->hash)) {
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
        $expires = $recoverPassword->find('hash=:hash', ':hash=' . $hash . '', 'expires_in')->fetch();

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
        $recover = $recoverPassword->find('user=:user', ':user=' . $login . '')->order('id', true)->fetch();

        if (empty($recover)) {
            $recoverPassword = new RecoverPassword();
            $recover = $recoverPassword->find('email=:email', ':email=' . $email . '')->order('id', true)->fetch();
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
            $user = $this->user->find('login=:login', ':login=' . $login . '')->fetch();

            if (empty($user)) {
                $this->user = new ModelsUser();
                $user = $this->user->find('email=:email', ':email=' . $email . '')->fetch();
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
