<?php
namespace Source\Controllers;

use Source\Core\Controller;
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
            
            $pathPhoto = !empty($this->getRequestFiles()->getFile('photoImage')['name']) ?
                $this->getRequestFiles()->getFile('photoImage')['name'] : null ;
            $data['pathPhoto'] = $pathPhoto;
            
            $user = new ModelUser();
            echo $user->register($data);
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
