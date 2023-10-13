<?php
namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\User;

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

    public function perfil()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $user = new User();
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        
        $isSystemArea = $this->getServer('REQUEST_URI') == '/braid/braid-system' ? 
        $this->getServer('REQUEST_URI') : null;

        $endpoint = $this->getServer("REQUEST_URI");

        echo $this->view->render("admin/perfil", [
            "isSystemArea" => $isSystemArea,
            "endpoint" => $endpoint,
            "breadCrumbTitle" => "Meu Perfil",
            "user" => [],
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }
}
