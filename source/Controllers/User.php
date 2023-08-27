<?php
namespace Source\Controllers;

use Source\Core\Controller;
use Source\Models\Designer;
use Source\Models\User as ModelsUser;
use Source\Support\RequestPost;

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
            
            $user = new ModelsUser();
            $user->name = $data['fullName'];
            $user->login = $data['userName'];
            $user->email = $data['email'];
            $user->password = $data['confirmPassword'];
            $user->document = '';
            $user->user_type = $data['userType'];
            $user->path_photo = '';
            if (!$user->save()) {
                throw new \Exception($user->fail());
            }
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
