<?php

namespace Source\Controllers;

use DateTime;
use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Credentials;
use Source\Domain\Model\Jobs;
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

    public function getLoginTokenData()
    {
        header("Content-Type: application/json");
        if (empty($this->getCurrentSession()->login_user)) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode(["invalid_request" => "acesso negado"]);
            die;
        }

        echo json_encode(["tokenData" => $this->getCurrentSession()->login_user->tokenData]);
    }

    public function chargeOnDemand(array $data = [])
    {
        header('Content-Type: application/json');
        if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode(["error" => "Cabeçalho de autorização ausente"]);
            die;
        }
        
        $tokenData = str_replace("Bearer: ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
        $data = base64_decode($data["hash"], true);
        if (!$data) {
            throw new \Exception("Hash base64 inválida");
        }

        $data = json_decode($data, true);
        $origin = $this->getServer("SERVER_NAME");
        $allowOrigin = ["clientes.laborcode.com.br", "braid.com.br"];

        if (!in_array($origin, $allowOrigin)) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode(['error' => 'Acesso negado']);
            die;
        }

        header("Access-Control-Allow-Origin: {$origin}");
        $errorMessage = [
            "invalid_parameter" => true,
            "msg" => "valor do parametro invalido"
        ];

        if (empty($data["page"])) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode($errorMessage);
            die;
        }

        if (empty($data["max"])) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode($errorMessage);
            die;
        }

        foreach ($data as $key => $value) {

            if ($key == "page" || $key == "max") {
                if (!preg_match("/^[\d]+$/", $value)) {
                    header("HTTP/1.1 500 Internal Server Error");
                    echo json_encode($errorMessage);
                    die;
                }

                if ($value < 0) {
                    header("HTTP/1.1 500 Internal Server Error");
                    echo json_encode($errorMessage);
                    die;
                }
            }

        }
        
        $credentials = new Credentials();
        $credentials = $credentials->getCredentials([
            "token_data" => $tokenData
        ]);

        if (empty($credentials)) {
            $this->getCurrentSession()->unset("login_user");
            echo json_encode(["invalid_token_data" => true, "url" => url("user/login")]);
            die;
        }

        $businessMan = new BusinessMan();
        $businessMan = $businessMan->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

        $offsetValue = ($data["page"] * $data["max"]) - $data["max"];
        $jobs = new Jobs();
        $jobs = $jobs->getJobsByBusinessManId($businessMan->id, $data["max"], $offsetValue);
        $jobArray = [];

        if (!empty($jobs)) {
            foreach ($jobs as $job) {
                $jobData = get_object_vars($job->data());
                $jobArray[] = $jobData;
            }
        }

        if (empty($jobArray)) {
            echo json_encode(["empty_projects" => true]);
            die;
        }

        echo json_encode($jobArray);
    }

    public function clientReportForm()
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            date_default_timezone_set("America/Sao_Paulo");
            $post = $this->getRequestPost()
                ->setRequiredFields(["jobName", "jobDescription", "remunerationData", "deliveryTime"])
                ->configureDataPost()->getAllPostData();

            $post["deliveryTime"] = str_replace("T", " ", $post["deliveryTime"]);
            if (strtotime($post["deliveryTime"]) < time()) {
                echo json_encode([
                    "invalid_datetime" => true,
                    "msg" => "Data de entrega não pode ser inferior a data de hoje"
                ]);
                die;
            }

            if (strlen($post["jobName"]) > 255) {
                echo json_encode(["invalid_length_job_name_field" => true,
                "msg" => "Campo nome do projeto excede o limite de caracteres"]);
                die;
            }
            
            if (strlen($post["jobDescription"]) > 255) {
                echo json_encode(["invalid_length_description_field" => true,
                "msg" => "Campo descrição do projeto excede o limite de caracteres"]);
                die;
            }

            $jobs = new Jobs();
            $post["remunerationData"] = $jobs->convertCurrencyRealToFloat($post["remunerationData"]);
            
            if (empty($post["remunerationData"])) {
                echo json_encode(["invalid_remuneration_data" => true, 
                "msg" => "Valor de remuneração inválido"]);
                die;
            }

            $businessMan = new BusinessMan();
            $objBusinessMan = $businessMan
                ->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

            if (empty($objBusinessMan)) {
                echo json_encode([
                    "general_error" => true,
                    "msg" => "Erro geral ao tentar criar uma tarefa"
                ]);
                die;
            }

            $businessMan->setId($objBusinessMan->id);
            $jobs->setBusinessMan($businessMan);
            $jobs->setJobName($post["jobName"]);
            $jobs->setJobDescription($post["jobDescription"]);
            $jobs->setRemuneration($post["remunerationData"]);
            $jobs->setDeliveryTime($post["deliveryTime"]);
            $jobs->setModelJob($jobs, $businessMan);

            echo json_encode([
                "success_create_job" => true,
                "url" => url("braid-system/client-report")
            ]);
            die;
        }

        $menuSelected = explode("/", $this->getServer("REQUEST_URI"));
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];
        $csrfToken = $this->getCurrentSession()->csrf_token;

        $user = new User();
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

        if ($this->getServer("REQUEST_METHOD") == "GET") {
            if ($userData->user_type != "businessman") {
                redirect("/braid-system/client-report");
            }
        }

        $breadCrumbTitle = $userData->user_type == "businessman" ? "Criar novo projeto"
            : "Trabalhos disponíveis";

        echo $this->view->render("admin/client-report-form", [
            "menuSelected" => $menuSelected,
            "csrfToken" => $csrfToken,
            "breadCrumbTitle" => $breadCrumbTitle,
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function clientReport()
    {
        $menuSelected = explode("/", $this->getServer("REQUEST_URI"));
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];
        $csrfToken = $this->getCurrentSession()->csrf_token;

        $businessMan = new BusinessMan();
        $businessMan = $businessMan
            ->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

        $jobs = new Jobs();
        $jobsData = $jobs->getJobsByBusinessManId($businessMan->id, 3);
        $totalJobs = $jobs->countTotalJobsByBusinessManId($businessMan->id);

        $user = new User();
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $breadCrumbTitle = $userData->user_type == "businessman" ? "Lista de projetos"
            : "Trabalhos disponíveis";

        echo $this->view->render("admin/client-report", [
            "totalJobs" => $totalJobs,
            "jobs" => $jobsData,
            "menuSelected" => $menuSelected,
            "csrfToken" => $csrfToken,
            "breadCrumbTitle" => $breadCrumbTitle,
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
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
            $post = $this->getRequestPost()->setRequiredFields([
                "fullName", "userName", "csrfToken",
                "csrf_token"
            ])->configureDataPost()->getAllPostData();

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
        $menuSelected = explode("/", $this->getServer("REQUEST_URI"));
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];
        $csrfToken = $this->getCurrentSession()->csrf_token;

        echo $this->view->render("admin/perfil", [
            "menuSelected" => $menuSelected,
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
