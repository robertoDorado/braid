<?php
namespace Source\Controllers;

use Source\Core\Controller;

/**
 * Cookie Source\Controllers
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Controllers
 */
class Cookie extends Controller
{
    /**
     * Cookie constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function privacyPolicy()
    {
        echo $this->view->render("cookies/privacy-policy", []);
    }

    public function agree()
    {
        $postCookie = empty($this->getRequestPost()->getPost("cookie")) 
            ? false : $this->getRequestPost()->getPost("cookie");

        setcookie("privacy-policy", $postCookie, time() + 3600, "/");
    }
}
