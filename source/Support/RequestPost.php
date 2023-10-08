<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * RequestPost Source\Support
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Support
 */
class RequestPost
{
    /** @var array Aramazena a variavel global $_POST */
    protected array $post;

    /** @var Session */
    protected $session;

    /** @var string Campo senha */
    protected string $password;

    /** @var string Campo confirme a senha */
    protected string $confirmPassword;

    /** @var bool Atributo para controlar atribuição da hash em campo do tipo senha */
    protected bool $hashPassword = true;

    /**
     * RequestPost constructor
     */
    public function __construct(Session $session)
    {
        $this->post = $_POST;
        $this->post = array_map(function ($value) {
            return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }, $this->post);
        $this->session = !empty($session) ? $session : null;
    }
    
    public function configureDataPost()
    {
        array_walk($this->post, [$this, 'formConfigure']);
        return $this;
    }

    private function verifyData(string $field, string $key, string $value) {
        if ($field == $key) {
            if ($value == '') {
                throw new \Exception("Campo " . $key . " é obrigatório.");
            }
        }
    }

    public function setHashPassword(bool $bool)
    {
        $this->hashPassword = $bool;
        return $this;
    }

    private function getHashPassword()
    {
        return $this->hashPassword;
    }

    public function setRequiredFields(array $requiredFields)
    {
        $verifyRequiredFields = function (&$value, $key) use ($requiredFields) {
            if (!empty($requiredFields)) {
                foreach ($requiredFields as $field) {
                    $this->verifyData($field, $key, $value);
                }
            }
        };

        array_walk($this->post, $verifyRequiredFields);
        return $this;
    }

    private function formConfigure(&$value, $key)
    {
        if ($key == "password") {
            $this->password = $value;
        }

        if ($key == "confirmPassword") {
            $this->confirmPassword = $value;
        }

        if (!empty($this->password) && !empty($this->confirmPassword)) {
            if ($this->password != $this->confirmPassword) {
                echo json_encode(["invalid_passwords_value" => true,
                "msg" => "Campo senha e confirme a sua senha são diferentes"]);
                die;
            }
        }

        if ($key == "csrfToken" || $key == "csrf_token") {
            if ($value != $this->session->csrf_token) {
                throw new \Exception("Token csrf inválido");
            }
        }

        if ($key == "email" || $key == "confirmEmail") {
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $value)) {
                throw new \Exception("Endereço de e-mail inválido");
            }
        }

        if ($key == "userName") {
            $userName = explode(" ", $value);
            $value = count($userName) > 0 ? implode("", $userName) : $value;
        }

        if ($this->getHashPassword()) {
            if ($key === 'password' || $key === 'confirmPassword') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
        }
    }

    public function getPost($key)
    {
        if (isset($this->post[$key]) && !empty($this->post[$key])) {
            return $this->post[$key];
        } else {
            throw new \Exception("chave " . $key . " POST não existe");
        }
    }

    public function getAllPostData()
    {
        return $this->post;
    }
}
