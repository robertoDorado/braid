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

        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $post = $this->getRequestPost()->setRequiredFields(["fullName", "userName", "csrfToken",
            "csrf_token"])->configureDataPost()->getAllPostData();

            $dataKey = base64_decode($post["dataKey"], true);

            if (!$dataKey) {
                throw new \Exception("Hash decodificada inválida");
            }

            if (base64_encode($dataKey) != base64_encode($this->getCurrentSession()->login_user->fullEmail)) {
                throw new \Exception("Valor da hash decodificada inválida");
            }

            unset($post["dataKey"]);
            $post["fullEmail"] = $dataKey;

            $requestFile = $this->getRequestFiles();

            $photoName = !empty($requestFile->getFile('photoImage')['name']) ?
                $requestFile->getFile('photoImage')['name'] : null;
            $post['pathPhoto'] = $photoName;

            if (!empty($post['pathPhoto'])) {
                $requestFile->uploadFile(__DIR__ . "./../../themes/braid-theme/assets/img/user", "photoImage");
            }

            $resultUpdate = $user->updateUserByEmail($post);

            if ($resultUpdate) {
                echo json_encode(["update_success" => true]);
                die;
            }
        }

        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        
        $isSystemArea = $this->getServer('REQUEST_URI') == '/braid/braid-system' ? 
        $this->getServer('REQUEST_URI') : null;

        $endpoint = $this->getServer("REQUEST_URI");
        $csrfToken = $this->getCurrentSession()->csrf_token;

        echo $this->view->render("admin/perfil", [
            "isSystemArea" => $isSystemArea,
            "endpoint" => $endpoint,
            "breadCrumbTitle" => "Meu Perfil",
            "csrfToken" => $csrfToken,
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }
}
