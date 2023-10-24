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

    public function updateUserByEmail(array $post)
    {
        if ($this->user instanceof ModelsUser) {

            $user = $this->user
            ->find("full_email=:full_email", ":full_email=" . $post["fullEmail"] . "")
            ->fetch();
            
            if (empty($user)) {
                throw new \Exception("Usuário não encontrado");
            }

            $user->full_name = $post["fullName"];
            $user->nick_name = $post["userName"];
            $user->path_photo = $post["pathPhoto"];
            if (!$user->save()) {
                echo json_encode(["general_error" => true,
                "msg" => "Erro geral ao tentar alterar o perfil do usuário"]);
                die;
            }

            return true;
        }
    }

    public function getUserByEmail(string $email)
    {
        if ($this->user instanceof ModelsUser) {

            if (empty($email)){
                throw new \Exception("Valor email não pode estar vazia");
            }

            $user = $this->user->find("full_email=:full_email", ":full_email=" . $email . "")
            ->fetch();

            if (empty($user)) {
                throw new \Exception("Usuário não existe.");
            }

            return $user;
        }
    }

    public function getFullNameByEmail(string $email)
    {
        if ($this->user instanceof ModelsUser) {
            $user = $this->user->find("full_email=:full_email", ":full_email=" . $email . "", "full_name")
            ->fetch();

            if (empty($user)) {
                echo json_encode(['email_does_not_exist' => true,
                'msg' => 'Este e-mail não está cadastrado']);
                die;
            }

            return $user->full_name;
        }
    }

    public function getNickNameByEmail(string $email)
    {
        if ($this->user instanceof ModelsUser) {
            $user = $this->user->find("full_email=:full_email", ":full_email=" . $email . "", "nick_name")
            ->fetch();

            if (empty($user)) {
                echo json_encode(['email_does_not_exist' => true,
                'msg' => 'Este e-mail não está cadastrado']);
                die;
            }

            return $user->nick_name;
        }
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

    public function login(string $login = '', string $email = '', string $password = '')
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

        $user = $this->getUserByLogin($this->login, $this->email);

        if (!empty($user)) {
            if ($user->is_valid_user == 0) {
                return null;
            }
        }

        if (empty($user)) {
            return null;
        }

        if (!password_verify($this->password, $user->password_data)) {
            return null;
        }

        return $user;
    }

    public function register(array $data)
    {
        if ($this->user instanceof ModelsUser) {
            $email = (new ModelsUser())
            ->find('full_email=:full_email', ':full_email=' . $data['email'] . '')->fetch();

            if (!empty($email)) {
                echo json_encode(['email_already_exists' => true,
                "msg" => "E-mail já foi cadastrado"]);
                die;
            }

            $nickName = (new ModelsUser())->find('nick_name=:nick_name', 
            ':nick_name=' . $data['userName'] . '')->fetch();

            if (!empty($nickName)) {
                echo json_encode(['nickname_already_exists' => true,
                'msg' => 'Nome de usuário já foi cadastrado']);
                die;
            }

            if (!$this->checkParamsNotEmpty($data['fullName'], $data['email'],
            $data['userName'], $data['confirmPassword'], $data['userType'])) {
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
                echo json_encode(["general_error" => true,
                "msg" => "Erro geral ao tentar criar o perfil do usuário"]);
                die;
            }

            return true;
        }

        return false;
    }

    public function requestRecoverPassword(string $login, string $email)
    {
        $user = $this->getUserByLogin($login, $email);

        if (empty($user)) {
            return false;
        }

        $hash = md5(uniqid(rand(), true));
        $recoverPassword = new RecoverPassword();
        $recoverPassword->id_user = $user->id;
        $recoverPassword->nick_name = $user->nick_name;
        $recoverPassword->full_email = $user->full_email;
        $recoverPassword->hash_data = $hash;
        $recoverPassword->is_valid = 1;
        $recoverPassword->expires_in = date('Y-m-d H:i:s', strtotime('+5 minute', time()));
        if (!$recoverPassword->save()) {
            throw new \Exception($recoverPassword->fail());
        }

        $data = $recoverPassword->find("hash_data=:hash_data", ":hash_data=" . $hash . "")
        ->fetch();

        if (empty($data)) {
            echo json_encode(['invalid_recover_password_data' => true,
            "msg" => "Erro na tentaiva de recuperar a senha"]);
            die;
        }

        return base64_encode($data->hash_data . "+" . $data->nick_name . "+" . $data->full_email);
    }

    public function recoverPassword(string $login, string $email, string $hash, string $confirmPassword): bool
    {
        $user = $this->getUserByLogin($login, $email);

        if (empty($user)) {
            return false;
        }

        $recoverPassword = $this->getRecoverPasswordByHash($hash);

        if ($recoverPassword->is_valid == 0) {
            return false;
        }

        $confirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);
        $user->password_data = $confirmPassword;
        $recoverPassword->is_valid = 0;

        if (!$recoverPassword->save()) {
            echo json_encode(["general_error" => true,
            "msg" => "Erro geral ao tentar recuperar o perfil do usuário"]);
            die;
        }
        
        if (!$user->save()) {
            echo json_encode(["general_error" => true,
            "msg" => "Erro geral ao tentar recuperar o perfil do usuário"]);
            die;
        }

        return true;
    }

    public function setInvalidHash($hash)
    {
        $recoverPassword = new RecoverPassword();
        $recoverPassword = $recoverPassword->find("hash_data=:hash_data",
        ":hash_data=" . $hash . "")->fetch();

        if (empty($recoverPassword)) {
            throw new \Exception("Dado de recuperação de senha não encontrado");
        }

        $recoverPassword->id_user = $recoverPassword->id_user;
        $recoverPassword->nick_name = $recoverPassword->nick_name;
        $recoverPassword->full_email = $recoverPassword->full_email;
        $recoverPassword->hash_data = $recoverPassword->hash_data;
        $recoverPassword->is_valid = 0;
        $recoverPassword->expires_in = $recoverPassword->expires_in;
        if (!$recoverPassword->save()) {
            throw new \Exception("Error ao atualizar o registro");
        }
    }

    public function isValidHash(string $hash): bool
    {
        $recoverPassword = new RecoverPassword();
        $expires = $recoverPassword->find('hash_data=:hash_data',
        ':hash_data=' . $hash . '', 'expires_in')
        ->fetch();

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
    private function getRecoverPasswordByHash(string $hash)
    {
        $recoverPassword = new RecoverPassword();
        $recover = $recoverPassword->find("hash_data=:hash_data", ":hash_data=" . $hash . "")
        ->fetch();

        if (empty($recover)) {
            throw new \Exception("Hash inválida");
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
        $user = $this->user->find('nick_name=:nick_name',
        ':nick_name=' . $login . '')->fetch();

        if (empty($user)) {
            $this->user = new ModelsUser();
            $user = $this->user->find('full_email=:full_email',
            ':full_email=' . $email . '')->fetch();
        }

        return $user;
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
