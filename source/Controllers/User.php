<?php
namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Designer;
use Source\Domain\Model\User as ModelUser;

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
            }

            if (!empty($businessMan->getId()) || !empty($designer->getId())) {
                echo json_encode(['register_success' => true, 'url_login' => url('user/login')]);
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
