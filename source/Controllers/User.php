<?php
namespace Source\Controllers;

use Source\Core\Controller;
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
            print_r($this->getRequestPost()->getAllPostData());
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
