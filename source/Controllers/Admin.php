<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Contract;
use Source\Domain\Model\Credentials;
use Source\Domain\Model\Designer;
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

    public function chargeOnDemandCandidates(array $data = [])
    {
        header('Content-Type: application/json');
        if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
            throw new \Exception("Cabeçalho de autorização ausente");
        }

        if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
            throw new \Exception("Formato de autorização inválido.");
        }

        $tokenData = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
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
            throw new \Exception(json_encode($errorMessage));
        }

        if (empty($data["max"])) {
            header("HTTP/1.1 500 Internal Server Error");
            throw new \Exception(json_encode($errorMessage));
        }

        if (empty($data["job_id"])) {
            header("HTTP/1.1 500 Internal Server Error");
            throw new \Exception(json_encode($errorMessage));
        }

        if (!preg_match("/^\d+$/", $data["job_id"])) {
            header("HTTP/1.1 500 Internal Server Error");
            throw new \Exception(json_encode($errorMessage));
        }

        foreach ($data as $key => $value) {

            if ($key == "page" || $key == "max") {
                if (!preg_match("/^[\d]+$/", $value)) {
                    header("HTTP/1.1 500 Internal Server Error");
                    throw new \Exception(json_encode($errorMessage));
                }

                if ($value < 0) {
                    header("HTTP/1.1 500 Internal Server Error");
                    throw new \Exception(json_encode($errorMessage));
                }
            }
        }

        $credentials = new Credentials();
        $credentials = $credentials->getCredentials([
            "token_data" => $tokenData
        ]);

        if (empty($credentials)) {
            throw new \Exception(json_encode(["invalid_token_data" => true]));
        }

        $response = [];
        $contract = new Contract();
        $contractData = $contract->getContractLeftJoinDesigner($data["job_id"]);
        $contractData = $contractData
            ->offset($data["page"])->limit($data["max"])->order("braid.contract.id", true)->fetch(true);

        foreach ($contractData as $contract) {
            array_push($response, $contract->data());
        }

        echo json_encode($response);
        die;
    }

    public function projectDetail(array $data = [])
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $data = json_decode(file_get_contents('php://input'), true);

            if (!empty($data["request_csrf_token"])) {
                if ($data["request_csrf_token"]) {
                    echo json_encode(["csrf_token" => $this->getCurrentSession()->csrf_token]);
                    die;
                }
            }

            $post = $this->getRequestPost()
                ->setRequiredFields(["csrf_token", "csrfToken", "additionalDescription"])
                ->configureDataPost()->getAllPostData();

            if (!preg_match("/^\d+$/", $post["jobId"])) {
                echo json_encode(["invalid_job_id" => true, "msg" => "Parâmetro inválido"]);
                die;
            }

            $designer = new Designer();
            $designerData = $designer
                ->getDesignerByEmail($this->getCurrentSession()->login_user->fullEmail);
            $designer->setId($designerData->id);

            $jobs = new Jobs();
            $jobsData = $jobs->getJobsById($post["jobId"]);
            $jobs->setId($jobsData->id);

            $contract = new Contract();
            $contract->setDesigner($designer);
            $contract->setJobs($jobs);
            $contract->setAdditionalDescription($post["additionalDescription"]);
            $contract->setSignatureBusinessMan(false);
            $contract->setSignatureDesigner(true);
            $contract->setModelContract($contract);

            echo json_encode([
                "contract_success" => true,
                "url" => url("/braid-system/client-report")
            ]);
            die;
        }

        $jobId = base64_decode($data["hash"], true);

        if (!$jobId) {
            redirect("braid-system/client-report");
        }

        if (!preg_match("/^\d+$/", $jobId)) {
            redirect("braid-system/client-report");
        }

        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];

        $user = new User();
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

        $job = new Jobs();
        $jobData = $job->getJobsById($jobId);

        $designer = new Designer();
        $contract = new Contract();

        if ($userData->user_type == "designer") {
            $designerData = $designer
                ->getDesignerByEmail($this->getCurrentSession()->login_user->fullEmail);

            $contractData = $contract->getContractByDesignerIdAndJobId($designerData->id, $jobData->id);
        }

        $candidatesDesigner = $contract->getContractLeftJoinDesigner($jobId);
        $candidatesDesignerData = $candidatesDesigner
            ->limit(3)->offset(0)->order("braid.contract.id", true)->fetch(true);

        $totalCandidatesDesigner = $candidatesDesigner->count();
        if (empty($jobData)) {
            redirect("braid-system/client-report");
        }

        echo $this->view->render("admin/project-detail", [
            "totalCandidatesDesigner" => $totalCandidatesDesigner,
            "candidatesDesigner" => $candidatesDesignerData,
            "contractData" => $contractData ?? null,
            "menuSelected" => $menuSelected,
            "breadCrumbTitle" => "Visualizar projeto",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type,
            "jobData" => $jobData
        ]);
    }

    public function deleteProject()
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
                throw new \Exception("Cabeçalho de autorização ausente");
            }

            if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
                throw new \Exception("Formato de autorização inválido.");
            }

            $tokenData = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
            $jobId = base64_decode($tokenData, true);

            if (!$jobId) {
                throw new \Exception("Erro ao tentar acessar parametro da requisição");
            }

            if (!preg_match("/^\d+$/", $jobId)) {
                throw new \Exception("Erro ao tentar acessar parametro da requisição");
            }

            $jobs = new Jobs();
            $jobs->deleteJobById($jobId);

            echo json_encode(["success_delete_project" => true, "id" => $jobId]);
        }
    }

    public function editProject(array $data = [])
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
                throw new \Exception("Cabeçalho de autorização ausente");
            }

            if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
                throw new \Exception("Formato de autorização inválido.");
            }

            $token = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
            $jobId = base64_decode($token, true);

            if (!$jobId) {
                throw new \Exception("Erro ao tentar acessar parametro da requisição");
            }

            if (!preg_match("/^\d+$/", $jobId)) {
                throw new \Exception("Erro ao tentar acessar parametro da requisição");
            }

            $post = $this->getRequestPost()->setRequiredFields([
                "jobName", "jobDescription",
                "csrfToken", "csrf_token", "remunerationData", "deliveryTime"
            ])->configureDataPost()
                ->getAllPostData();

            $post["id"] = $jobId;
            $post["deliveryTime"] = str_replace("T", " ", $post["deliveryTime"]);
            if (strtotime($post["deliveryTime"]) < time()) {
                echo json_encode([
                    "invalid_datetime" => true,
                    "msg" => "Data de entrega não pode ser inferior a data de hoje"
                ]);
                die;
            }

            if (strlen($post["jobName"]) > 255) {
                echo json_encode([
                    "invalid_length_job_name_field" => true,
                    "msg" => "Campo nome do projeto excede o limite de caracteres"
                ]);
                die;
            }

            if (strlen($post["jobDescription"]) > 1000) {
                echo json_encode([
                    "invalid_length_description_field" => true,
                    "msg" => "Campo descrição do projeto excede o limite de caracteres"
                ]);
                die;
            }

            $jobs = new Jobs();
            $post["remunerationData"] = convertCurrencyRealToFloat($post["remunerationData"]);

            if (empty($post["remunerationData"])) {
                echo json_encode([
                    "invalid_remuneration_data" => true,
                    "msg" => "Valor de remuneração inválido"
                ]);
                die;
            }

            $response = $jobs->updateJobById($post);
            echo $response ? json_encode([
                "success_update_job" => true,
                "url" => url("braid-system/client-report")
            ]) : json_encode([
                "general_error" => true,
                "msg" => "Erro geral ao tentar atualizar os dados do projeto"
            ]);
            die;
        }

        $jobId = base64_decode($data["hash"], true);

        if (!$jobId) {
            redirect("/braid-system/client-report");
        }

        if (!preg_match("/^\d+$/", $jobId)) {
            redirect("/braid-system/client-report");
        }

        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
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
        $jobs = new Jobs();
        $jobData = $jobs->getJobsById($jobId);

        if ($userData->user_type != "businessman") {
            redirect("/braid-system/client-report");
        }

        if (empty($jobData)) {
            redirect("/braid-system/client-report");
        }

        echo $this->view->render("admin/client-report-edit", [
            "jobData" => $jobData,
            "menuSelected" => $menuSelected,
            "csrfToken" => $csrfToken,
            "breadCrumbTitle" => "Editar projeto",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function searchProject()
    {
        header("Content-Type: application/json");
        if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
            throw new \Exception("Cabeçalho de autorização ausente");
        }

        if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
            throw new \Exception("Formato de autorização inválido.");
        }

        $tokenData = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
        $credentials = new Credentials();

        $credentials = $credentials->getCredentials([
            "token_data" => $tokenData
        ]);

        if (empty($credentials)) {
            throw new \Exception(json_encode(["invalid_token_data" => true]));
        }

        $searchValue = $this->get("searchProject");
        if (empty($searchValue)) {
            header("HTTP/1.1 403 Forbidden");
            echo json_encode(["invalid_request" => "acesso negado"]);
            die;
        }

        $businessMan = new BusinessMan();
        $businessMan = $businessMan
            ->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

        $jobs = new Jobs();
        $jobsResponse = $jobs->getJobsLikeQuery([
            "job_name" => $searchValue,
            "job_description" => $searchValue
        ], 3);
        $jobsData = [];

        if (!empty($businessMan)) {
            if (!empty($jobsResponse)) {
                foreach ($jobsResponse as $job) {
                    if ($businessMan->id == $job->business_man_id) {
                        array_push($jobsData, $job);
                    }
                }
            }
        } else {
            $jobsData = $jobsResponse;
        }


        echo empty($jobsData) ?
            json_encode(["empty_request" => true, "msg" => "Nenhum projeto encontrado"])
            : json_encode($jobsData);
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
            throw new \Exception("Cabeçalho de autorização ausente");
        }

        if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
            throw new \Exception("Formato de autorização inválido.");
        }

        $tokenData = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
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
            throw new \Exception(json_encode($errorMessage));
        }

        if (empty($data["max"])) {
            header("HTTP/1.1 500 Internal Server Error");
            throw new \Exception(json_encode($errorMessage));
        }

        foreach ($data as $key => $value) {

            if ($key == "page" || $key == "max") {
                if (!preg_match("/^[\d]+$/", $value)) {
                    header("HTTP/1.1 500 Internal Server Error");
                    throw new \Exception(json_encode($errorMessage));
                }

                if ($value < 0) {
                    header("HTTP/1.1 500 Internal Server Error");
                    throw new \Exception(json_encode($errorMessage));
                }
            }
        }

        $credentials = new Credentials();
        $credentials = $credentials->getCredentials([
            "token_data" => $tokenData
        ]);

        if (empty($credentials)) {
            throw new \Exception(json_encode(["invalid_token_data" => true]));
        }

        $user = new User();
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $jobs = new Jobs();
        $offsetValue = ($data["page"] * $data["max"]) - $data["max"];

        if ($userData->user_type == "businessman") {
            $businessMan = new BusinessMan();
            $businessMan = $businessMan->getBusinessManByEmail($userData->full_email);

            $jobsData = $jobs->getJobsByBusinessManId($businessMan->id, $data["max"], $offsetValue, true);
            $totalJobsData = $jobs->countTotalJobsByBusinessManId($businessMan->id);
        } else {
            $jobsData = $jobs->getAllJobs(3, $offsetValue, true);
            $totalJobsData = $jobs->countTotalJobs();
        }

        $jobsData[] = ["total_jobs" => $totalJobsData];
        if (empty($jobsData)) {
            echo json_encode(["empty_projects" => true]);
            die;
        }

        echo json_encode($jobsData);
    }

    public function clientReportForm()
    {
        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $post = $this->getRequestPost()
                ->setRequiredFields([
                    "jobName", "jobDescription",
                    "csrfToken", "csrf_token", "remunerationData", "deliveryTime"
                ])
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
                echo json_encode([
                    "invalid_length_job_name_field" => true,
                    "msg" => "Campo nome do projeto excede o limite de caracteres"
                ]);
                die;
            }

            if (strlen($post["jobDescription"]) > 1000) {
                echo json_encode([
                    "invalid_length_description_field" => true,
                    "msg" => "Campo descrição do projeto excede o limite de caracteres"
                ]);
                die;
            }

            $jobs = new Jobs();
            $post["remunerationData"] = convertCurrencyRealToFloat($post["remunerationData"]);

            if (empty($post["remunerationData"])) {
                echo json_encode([
                    "invalid_remuneration_data" => true,
                    "msg" => "Valor de remuneração inválido"
                ]);
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
            $jobs->setModelJob($jobs);

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
        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
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
        $jobs = new Jobs();

        if ($userData->user_type == "businessman") {
            $businessMan = new BusinessMan();
            $businessMan = $businessMan
                ->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

            $jobsData = $jobs->getJobsByBusinessManId($businessMan->id, 3, 0, true, true);
            $totalJobs = $jobs->countTotalJobsByBusinessManId($businessMan->id);
        } else {
            $jobsData = $jobs->getAllJobs(3, 0, true, true);
            $totalJobs = $jobs->countTotalJobs();
        }

        $breadCrumbTitle = $userData->user_type == "businessman" ? "Lista de projetos"
            : "Projetos disponíveis";

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
        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
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
