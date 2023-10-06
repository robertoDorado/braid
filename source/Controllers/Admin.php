<?php
namespace Source\Controllers;

use Source\Core\Controller;

/**
 * Admin Controllers
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Controllers
 */
class Admin extends Controller
{
    /**
     * Admin constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function exit()
    {
        if ($this->getServer('REQUEST_METHOD') == "POST") {

            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data["action"]) && $data["action"] == "logout") {
                $this->getCurrentSession()->unset("login_user");
                echo json_encode(["logout_success" => true, "url" => url("/user/login")]);
                die;
            }
        }
    }

    public function index()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }
        
        $isSystemArea = $this->getServer('REQUEST_URI') == '/braid/braid-system' ? 
        $this->getServer('REQUEST_URI') : null;

        echo $this->view->render("admin/index", [
            "isSystemArea" => $isSystemArea,
            "fullName" => $this->getCurrentSession()->login_user->fullName,
            "nickName" => $this->getCurrentSession()->login_user->nickName,
            "pathPhoto" => $this->getCurrentSession()->login_user->pathPhoto,
            "userType" => $this->getCurrentSession()->login_user->userType
        ]);
    }
}
