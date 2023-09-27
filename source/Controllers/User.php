<?php
namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Designer;
use Source\Domain\Model\User as ModelUser;
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
        echo $this->view->render("admin/login", []);
    }

    public function register()
    {
        if ($this->getServer('REQUEST_METHOD') == 'POST') {
            $data = $this->getRequestPost()->setRequiredFields(["fullName", "userName", "email", 
                "password", "confirmPassword", "csrfToken", "csrf_token", "userType"])->getAllPostData();
            
            $requestFile = $this->getRequestFiles();
            $photoName = !empty($requestFile->getFile('photoImage')['name']) ?
                $requestFile->getFile('photoImage')['name'] : null;
            $data['pathPhoto'] = $photoName;

            if (!empty($data['pathPhoto'])) {
                $requestFile->uploadFile(__DIR__ . "./../upload/user", "photoImage");
            }
            
            $user = new ModelUser();
            $businessMan = new BusinessMan();
            $designer = new Designer();

            if ($user->register($data)) {
                if ($data['userType'] == "businessman") {
                    $businessMan->setCeoName($data["fullName"]);
                    $businessMan->setEmail($data['email']);
                    $businessMan->setModelBusinessMan($businessMan);
                }else if ($data["userType"] == "designer") {
                    $designer->setDesignerName($data["fullName"]);
                    $designer->setEmail($data['email']);
                    $designer->setModelDesigner($designer);
                }

                if (!empty($businessMan->getEmail()) || !empty($designer->getEmail())) {
                    Mail::sendEmail(["emailFrom" => "no-reply@braid.com", "nameFrom" => "Braid.pro",
                    "emailTo" => $data["email"], "nameTo" => $data["fullName"],
                    "body" => Mail::loadTemplateConfirmEmail([
                        "url" => __DIR__ . "./../../themes/braid-theme/mail/confirm-email.php",
                        "name" => $data["fullName"],
                        "email" => $data["email"],
                        "link" => url("/user/email-confirmed?dataMail=" . base64_encode($data["email"]) . "")
                    ]),
                    "subject" => iconv("UTF-8", "ISO-8859-1//TRANSLIT", "Confirmação de e-mail")]);
                }
            }

            if (!empty($businessMan->getId()) || !empty($designer->getId())) {
                echo json_encode(['register_success' => true, 
                    'url_login' => url('/user/confirm-email?dataMail='. base64_encode($data["email"]) .'')]);
            }
            exit;
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
        echo $this->view->render("admin/register", [
            'registerType' => $registerType,
            'csrfToken' =>  $csrfToken
        ]);
    }
}
