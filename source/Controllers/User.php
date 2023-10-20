<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Credentials;
use Source\Domain\Model\Designer;
use Source\Domain\Model\User as ModelUser;
use Source\Models\RecoverPassword;
use Source\Support\Mail;

/**
 * User Source\Controllers
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Controllers
 */
class User extends Controller
{
    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function token()
    {
        header('Content-Type: application/json');
        $origin = $this->getServer("SERVER_NAME");
        $allowOrigin = ["clientes.laborcode.com.br", "braid.com.br"];
        $accessDenied = ['error' => 'Acesso negado'];

        if (!in_array($origin, $allowOrigin)) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode($accessDenied);
            die;
        }

        header("Access-Control-Allow-Origin: {$origin}");
        $post = json_decode(file_get_contents('php://input'), true);

        if (empty($post["username"])) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode($accessDenied);
            die;
        }

        if (empty($post["password"])) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode($accessDenied);
            die;
        }

        $user = new ModelUser();
        $credentialsLabel = "Login de Usuário";
        $descriptionCredentials = "Token de Autenticação do usuário";
        $credentials = new Credentials();
        $bytes = random_bytes(32);
        $token = bin2hex($bytes);

        if (isEmail($post["username"])) {
            if (isValidEmail($post["username"])) {
                $user = $user->login('', $post["username"], $post["password"]);

                if (empty($user)) {
                    echo json_encode([
                        'access_denied' => true,
                        'msg' => 'Usuário ou senha inválido'
                    ]);
                    die;
                }

                $jsonCredentials = json_encode([
                    "fullName" => $user->full_name,
                    "userName" => $user->nick_name,
                    "fullEmail" => $user->full_email,
                    "passwordData" => $user->password_data,
                    "userType" => $user->user_type,
                    "isValidUser" => $user->is_valid_user
                ]);

                $credentialsData = $credentials->getCredentials([
                    "credentials_label" => $credentialsLabel,
                    "description_credentials" => $descriptionCredentials,
                    "json_credentials" => $jsonCredentials
                ], true);

                if (empty($credentialsData)) {
                    $credentials->setCredentialsFromUser([
                        "credentialsLabel" => $credentialsLabel,
                        "descriptionCredentials" => $descriptionCredentials,
                        "jsonCredentials" => $jsonCredentials,
                        "tokenData" => $token
                    ]);

                    $credentialsData = $credentials->getCredentials([
                        "credentials_label" => $credentialsLabel,
                        "description_credentials" => $descriptionCredentials,
                        "json_credentials" => $jsonCredentials
                    ], true);
                }

                echo $credentialsData;
                die;

            } else {
                echo json_encode([
                    'invalid_email' => true,
                    'msg' => 'Tipo de e-mail inválido'
                ]);
                die;
            }
        } else {
            $user = $user->login($post["username"], '', $post["password"]);

            if (empty($user)) {
                echo json_encode([
                    'access_denied' => true,
                    'msg' => 'Usuário ou senha inválido'
                ]);
                die;
            }

            $jsonCredentials = json_encode([
                "fullName" => $user->full_name,
                "userName" => $user->nick_name,
                "fullEmail" => $user->full_email,
                "passwordData" => $user->password_data,
                "userType" => $user->user_type,
                "isValidUser" => $user->is_valid_user
            ]);

            $credentialsData = $credentials->getCredentials([
                "credentials_label" => $credentialsLabel,
                "description_credentials" => $descriptionCredentials,
                "json_credentials" => $jsonCredentials
            ], true);

            if (empty($credentialsData)) {
                $credentials->setCredentialsFromUser([
                    "credentialsLabel" => $credentialsLabel,
                    "descriptionCredentials" => $descriptionCredentials,
                    "jsonCredentials" => $jsonCredentials,
                    "tokenData" => $token
                ]);

                $credentialsData = $credentials->getCredentials([
                    "credentials_label" => $credentialsLabel,
                    "description_credentials" => $descriptionCredentials,
                    "json_credentials" => $jsonCredentials
                ], true);
            }

            echo $credentialsData;
            die;
        }
    }

    public function successChangePassword()
    {
        echo $this->view->render("user/success-change-password", []);
    }

    public function expiredLinkRecoverPassword()
    {
        echo $this->view->render("user/expired-link-recover-password", []);
    }

    public function recoverPasswordForm()
    {
        if ($this->getServer("REQUEST_METHOD") == "GET") {
            if (empty($this->get("dataRecover"))) {
                redirect("user/recover-password");
            }
        }

        $user = new ModelUser();
        $data = base64_decode($this->get("dataRecover"));
        $data = explode("+", $data);

        if ($this->getServer("REQUEST_METHOD") == "GET") {
            $recoverPassword = (new RecoverPassword())
                ->find("hash_data=:hash_data", ":hash_data=" . $data[0] . "")->fetch();

            if (empty($recoverPassword)) {
                throw new \Exception("Hash inválida");
            }

            if ($recoverPassword->is_valid == 0) {
                redirect("/user/expired-link-recover-password");
            }
        }

        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $post = $this->getRequestPost()
                ->setHashPassword(false)
                ->setRequiredFields([
                    "csrf_token", "csrfToken", "password",
                    "confirmPassword", "nickName", "userEmail", "hash"
                ])
                ->configureDataPost()
                ->getAllPostData();

            if (!isValidPassword($post["confirmPassword"])) {
                echo json_encode([
                    "invalid_password_value" => true,
                    "msg" => "Tipo de senha inválida"
                ]);
                die;
            }

            if (!$user->recoverPassword($post["nickName"], $post["userEmail"], $post["hash"], $post["confirmPassword"])) {
                echo json_encode([
                    "expired_link" => true,
                    "url" => url("/user/expired-link-recover-password")
                ]);
                die;
            }

            echo json_encode([
                "success_password_change" => true,
                "url" => url("/user/success-change-password")
            ]);
            die;
        }

        if (!$user->isValidHash($data[0])) {
            $user->setInvalidHash($data[0]);
            redirect("/user/expired-link-recover-password");
        }

        $csrfToken = $this->getCurrentSession()->csrf_token;
        echo $this->view->render("user/recover-password-form", [
            "hash" => $recoverPassword->hash_data,
            "nickName" => $data[1],
            "userEmail" => $data[2],
            "csrfToken" => $csrfToken
        ]);
    }

    public function recoverPasswordMessage()
    {
        if (empty($this->get("dataMail"))) {
            redirect("user/recover-password");
        }

        $userEmail = base64_decode($this->get("dataMail"));
        echo $this->view->render("user/recover-password-message", [
            "userEmail" => $userEmail
        ]);
    }

    public function recoverPassword()
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $userEmail = $this->getRequestPost()->setRequiredFields(["csrf_token", "csrfToken", "userEmail"])
                ->configureDataPost()->getPost("userEmail");

            if (!isValidEmail($userEmail)) {
                echo json_encode([
                    'invalid_email_value' => true,
                    "msg" => "Tipo de e-mail inválido"
                ]);
                die;
            }

            $user = new ModelUser();
            $nickName = $user->getNickNameByEmail($userEmail);
            $fullName = $user->getFullNameByEmail($userEmail);

            $dataRecover = $user->requestRecoverPassword($nickName, $userEmail);
            $link = url("/user/recover-password-form") . "?dataRecover=" . $dataRecover;

            Mail::sendEmail([
                "emailFrom" => "no-reply@braid.com", "nameFrom" => "Braid.pro",
                "emailTo" => $userEmail, "nameTo" => $fullName,
                "body" => Mail::loadTemplateConfirmEmail([
                    "url" => __DIR__ . "./../../themes/braid-theme/mail/recover-password.php",
                    "name" => $fullName,
                    "email" => $userEmail,
                    "link" => $link
                ]),
                "subject" => iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Recuperação de senha")
            ]);

            echo json_encode([
                "recover_success" => true,
                "url" => url("/user/recover-password-message?dataMail=" . base64_encode($userEmail))
            ]);
            die;
        }

        $csrfToken = $this->getCurrentSession()->csrf_token;
        echo $this->view->render("user/recover-password", [
            "csrfToken" => $csrfToken
        ]);
    }

    public function emailConfirmed()
    {
        if (empty($this->get("dataMail"))) {
            redirect("/");
        }

        $user = new ModelUser();
        $isValidUser = $user->validateEmailFirstAccess($this->get("dataMail"));

        echo $this->view->render("user/email-confirmed", [
            "isValidUser" => $isValidUser
        ]);
    }

    public function confirmEmail()
    {
        if (empty($this->get("dataMail"))) {
            redirect("/");
        }

        $email = !empty($this->get("dataMail")) ? base64_decode($this->get("dataMail")) : '';
        if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            redirect("/");
        }

        echo $this->view->render("user/confirm-email", [
            "email" => $email
        ]);
    }

    public function login()
    {
        $user = new ModelUser();
        if ($this->getServer('REQUEST_METHOD') == 'POST') {
            $post = $this->getRequestPost()->setHashPassword(false)
                ->setRequiredFields([
                    "userName", "password",
                    "csrf_token", "csrfToken"
                ])->configureDataPost()->getAllPostData();

            $loginInput = $post["userName"];
            $remember = empty($post["remember"]) ? 'off' : $post["remember"];
            $password = $post["password"];

            if (!isValidPassword($password)) {
                echo json_encode([
                    'invalid_password' => true,
                    'msg' => 'Tipo de senha inválido'
                ]);
                die;
            }

            if (isEmail($loginInput)) {
                if (isValidEmail($loginInput)) {
                    $user = $user->login('', $loginInput, $password);

                    if (empty($user)) {
                        echo json_encode([
                            'access_denied' => true,
                            'msg' => 'Usuário ou senha inválido'
                        ]);
                        die;
                    }

                    if ($remember == 'on') {
                        setcookie("user_login", $loginInput, time() + 3600, url("user/login"));
                        setcookie("user_password", $password, time() + 3600, url("user/login"));
                    }

                    $this->getCurrentSession()->set("login_user", [
                        "fullEmail" => $user->full_email,
                    ]);

                    echo json_encode(['success_login' => true, "url" => url("/braid-system")]);
                    die;
                } else {
                    echo json_encode([
                        'invalid_email' => true,
                        'msg' => 'Tipo de e-mail inválido'
                    ]);
                    die;
                }
            } else {
                $user = $user->login($loginInput, '', $password);

                if (empty($user)) {
                    echo json_encode([
                        'access_denied' => true,
                        'msg' => 'Usuário ou senha inválido'
                    ]);
                    die;
                }

                if ($remember == 'on') {
                    setcookie("user_login", $loginInput, time() + 3600, url("user/login"));
                    setcookie("user_password", $password, time() + 3600, url("user/login"));
                }

                $this->getCurrentSession()->set("login_user", [
                    "fullEmail" => $user->full_email,
                ]);

                echo json_encode(['success_login' => true, "url" => url("/braid-system")]);
            }

            die;
        }

        $userLogin = "";
        $userPassword = "";

        if (!empty($_COOKIE["user_login"]) && !empty($_COOKIE["user_password"])) {
            $userLogin = $_COOKIE["user_login"];
            $userPassword = $_COOKIE["user_password"];
        }

        $csrfToken = $this->getCurrentSession()->csrf_token;
        echo $this->view->render("user/login", [
            "csrfToken" => $csrfToken,
            "userLogin" => $userLogin,
            "userPassword" => $userPassword
        ]);
    }

    public function register()
    {
        if ($this->getServer('REQUEST_METHOD') == 'POST') {
            $data = $this->getRequestPost()
                ->setRequiredFields([
                    "fullName", "userName", "email",
                    "password", "confirmPassword", "csrfToken", "csrf_token", "userType"
                ])
                ->configureDataPost()->getAllPostData();

            $requestFile = $this->getRequestFiles();
            $photoName = !empty($requestFile->getFile('photoImage')['name']) ?
                $requestFile->getFile('photoImage')['name'] : null;
            $data['pathPhoto'] = $photoName;

            if (!empty($data['pathPhoto'])) {
                $requestFile->uploadFile(__DIR__ . "./../../themes/braid-theme/assets/img/user", "photoImage");
            }

            $user = new ModelUser();
            $businessMan = new BusinessMan();
            $designer = new Designer();

            if ($user->register($data)) {
                if ($data['userType'] == "businessman") {
                    $businessMan->setCeoName($data["fullName"]);
                    $businessMan->setEmail($data['email']);
                    $businessMan->setModelBusinessMan($businessMan);
                } else if ($data["userType"] == "designer") {
                    $designer->setDesignerName($data["fullName"]);
                    $designer->setEmail($data['email']);
                    $designer->setModelDesigner($designer);
                }

                if (!empty($businessMan->getEmail()) || !empty($designer->getEmail())) {
                    Mail::sendEmail([
                        "emailFrom" => "no-reply@braid.com", "nameFrom" => "Braid.pro",
                        "emailTo" => $data["email"], "nameTo" => $data["fullName"],
                        "body" => Mail::loadTemplateConfirmEmail([
                            "url" => __DIR__ . "./../../themes/braid-theme/mail/confirm-email.php",
                            "name" => $data["fullName"],
                            "email" => $data["email"],
                            "link" => url("/user/email-confirmed?dataMail=" . base64_encode($data["email"]) . "")
                        ]),
                        "subject" => iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Confirmação de e-mail")
                    ]);
                }
            }

            if (!empty($businessMan->getId()) || !empty($designer->getId())) {
                echo json_encode([
                    'register_success' => true,
                    'url_login' => url('/user/confirm-email?dataMail=' . base64_encode($data["email"]) . '')
                ]);
            }
            die;
        }

        if (!$this->has('userType')) {
            redirect("/");
        }

        $validUserType = ['businessman', 'designer', 'generic'];
        if (!in_array($this->get('userType'), $validUserType)) {
            redirect("/");
        }

        $csrfToken = $this->getCurrentSession()->csrf_token;
        $registerType = $this->get('userType');
        echo $this->view->render("user/register", [
            'registerType' => $registerType,
            'csrfToken' =>  $csrfToken
        ]);
    }
}
