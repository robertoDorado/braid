<?php

namespace Source\Controllers;

use Source\Core\Controller;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Contact;
use Source\Domain\Model\Contract;
use Source\Domain\Model\Conversation;
use Source\Domain\Model\Credentials;
use Source\Domain\Model\Designer;
use Source\Domain\Model\EvaluationDesigner;
use Source\Domain\Model\Jobs;
use Source\Domain\Model\Messages;
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

    public function profileDataJson(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        header('Content-Type: application/json');
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

        $profileEmail = base64_decode($data["hash"], true);

        if (!$profileEmail) {
            throw new \Exception("hash inválida");
        }

        if (!isValidEmail($profileEmail)) {
            throw new \Exception("parametro profile_id inválido");
        }

        $businessMan = new BusinessMan();
        $designer = new Designer();
        $user = new User();

        $receiverData = $designer->getDesignerByEmail($profileEmail);

        if (empty($receiverData)) {
            $receiverData = $businessMan->getBusinessManByEmail($profileEmail);
        }

        if (empty($receiverData)) {
            throw new \Exception("Objeto receptor não existe");
        }

        $receiverData = $user->getUserByEmail($receiverData->full_email);
        if (empty($receiverData)) {
            throw new \Exception("Objeto receptor não existe");
        }

        echo json_encode(["success" => true, "receiverEmail" => $receiverData->full_email]);
    }

    public function chatMessages(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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

        $chatData = base64_decode($data["hash"], true);

        if (!$chatData) {
            throw new \Exception("parametro chat box inválido");
        }

        $chatData = json_decode($chatData, true);
        $post = $this->getRequestPost()
            ->setRequiredFields(["csrf_token", "csrfToken"])
            ->configureDataPost()->getAllPostData();

        if (empty($post["messageData"])) {
            die;
        }

        $user = new User();
        $message = new Messages();
        $conversation = new Conversation();
        $contact = new Contact();

        $senderData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        if (empty($senderData)) {
            throw new \Exception("usuário sender não existe");
        }

        $receiverData = $user->getUserByEmail($chatData["receiverEmail"]);
        if (empty($receiverData)) {
            throw new \Exception("usuário receiver não existe");
        }

        $senderUser = new User();
        $senderUser->setId($senderData->id);

        $receiverUser = new User();
        $receiverUser->setId($receiverData->id);

        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $user->setId($userData->id);

        $message->setSenderUser($senderUser);
        $message->setReceiverUser($receiverUser);
        $message->setContent($post["messageData"]);
        $message->setDateTime(date("Y-m-d H:i:s"));
        $message->setModelMessage($message);

        $conversation->setUser($senderUser);
        $conversation->setMessage($message);
        $conversation->setModelConversation($conversation);

        $contact->setUser($user);
        $contact->setConversation($conversation);
        $contact->setModelContact($contact);

        $data = [];
        if (!empty($senderData)) {
            $data = [
                "success" => true,
                "pathPhoto" => $senderData->path_photo,
                "fullName" => $senderData->full_name,
                "content" => $post["messageData"],
                "dateTime" => date("d/m/Y H:i")
            ];
        }
        
        echo json_encode($data);
    }

    public function chatPanelUser()
    {
        header('Content-Type: application/json');
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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

        $post = $this->getRequestPost()
            ->setRequiredFields(["csrfToken", "csrf_token", "paramProfileData"])
            ->configureDataPost()->getAllPostData();

        $designer = new Designer();
        $businessMan = new BusinessMan();
        $user = new User();

        $profileEmail = base64_decode($post["paramProfileData"], true);
        if (!$profileEmail) {
            throw new \Exception("Parametro designer_id inválido");
        }

        if (!isValidEmail($profileEmail)) {
            throw new \Exception("Parametro designer_id inválido");
        }

        $receiverData = $designer->getDesignerByEmail($profileEmail);

        if (empty($receiverData)) {
            $receiverData = $businessMan->getBusinessManByEmail($profileEmail);
        }

        $receiverData = $user->getUserByEmail($receiverData->full_email);
        if (empty($receiverData)) {
            throw new \Exception("Objeto receptor não existe");
        }

        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        if (empty($userData)) {
            throw new \Exception("Objeto usuário não existe");
        }
        $user->setId($userData->id);

        $receiverUser = new User();
        $receiverUser->setId($receiverData->id);

        $chatData = [
            "success" => true,
            "receiverName" => $receiverData->full_name,
            "receiverUser" => $receiverUser,
            "user" => $user,
            "paramProfileData" => $post["paramProfileData"],
            "fullEmail" => $this->getCurrentSession()->login_user->fullEmail,
            "tokenData" => $this->getCurrentSession()->login_user->tokenData
        ];

        $this->getCurrentSession()->set("login_user", $chatData);
        echo json_encode($chatData);
    }

    public function chatPanel()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        if ($this->getServer("REQUEST_METHOD") == "POST") {
            $post = $this->getRequestPost()
                ->setRequiredFields(["csrfToken", "csrf_token"])
                ->configureDataPost()->getAllPostData();

            if (isset($post["closeChat"])) {
                if ($post["closeChat"]) {
                    $this->getCurrentSession()->set("login_user", [
                        "isChatClosed" => true,
                        "fullEmail" => $this->getCurrentSession()->login_user->fullEmail,
                        "tokenData" => $this->getCurrentSession()->login_user->tokenData
                    ]);
                }
            }

            if (isset($post["openChat"])) {
                if ($post["openChat"]) {
                    $this->getCurrentSession()->set("login_user", [
                        "isChatClosed" => false,
                        "fullEmail" => $this->getCurrentSession()->login_user->fullEmail,
                        "tokenData" => $this->getCurrentSession()->login_user->tokenData
                    ]);
                }
            }
        }

        $user = new User();
        $conversation = new Conversation();
        $contact = new Contact();

        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

        if (!empty($this->getCurrentSession()->login_user->receiverUser) && !empty($this->getCurrentSession()->login_user->user)) {
            $conversationData = $conversation
                ->getConversationAndMessages([$this->getCurrentSession()->login_user->user->getId(), $this->getCurrentSession()->login_user->receiverUser->getId()]);
        }

        $receiverName = empty($this->getCurrentSession()->login_user->success) ? "Chat" :
            $this->getCurrentSession()->login_user->receiverName;
        $receiverEmail = empty($this->getCurrentSession()->login_user->paramProfileData) ? null :
            $this->getCurrentSession()->login_user->paramProfileData;

        if (!empty($conversationData)) {
            foreach ($conversationData as &$conversationValue) {
                $conversationValue->is_receiver = $this->getCurrentSession()->login_user->user->getId() == $conversationValue->receiver_id ? true : false;
                $conversationValue->is_sender = $this->getCurrentSession()->login_user->user->getId() == $conversationValue->sender_id ? true : false;
            }
        }

        $user->setId($userData->id);
        $contactsData = $contact->getContactsUserByIdUser($user);
        $csrfToken = $this->getCurrentSession()->csrf_token;

        echo $this->view->render("admin/chat-panel", [
            "csrfToken" => $csrfToken,
            "contactsData" => $contactsData,
            "receiverName" => $receiverName,
            "receiverEmail" => $receiverEmail,
            "conversationData" => $conversationData ?? null,
            "menuSelected" => $menuSelected,
            "breadCrumbTitle" => "Painel de chat",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function saveBreadCrumbLink()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $post = $this->getRequestPost()
            ->setRequiredFields(["linkBreadCrumbBefore", "csrfToken", "csrf_token"])
            ->configureDataPost()->getAllPostData();

        $this->getCurrentSession()->set("linkBreadCrumbBefore", $post["linkBreadCrumbBefore"]);
        echo json_encode(["success" => true]);
    }

    public function companyProfile(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $user = new User();
        $businessMan = new BusinessMan();

        $profileEmail = base64_decode($data["hash"], true);
        if (!$profileEmail) {
            redirect("braid-system/my-profile");
        }

        if (!isValidEmail($profileEmail)) {
            redirect("braid-system/my-profile");
        }

        $profileData = $businessMan->getBusinessManByEmail($profileEmail);
        if (empty($profileData)) {
            redirect("braid-system/my-profile");
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
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $csrfToken = $this->getCurrentSession()->csrf_token;

        echo $this->view->render("admin/company-profile", [
            "csrfToken" => $csrfToken,
            "positionData" => $profileData->company_name,
            "menuSelected" => $menuSelected,
            "profileData" => $profileData,
            "breadCrumbTitle" => "Detalhes do perfil",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function additionalData()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $user = new User();
        $currentUser = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $personObject = $currentUser->user_type == "designer" ? new Designer() : new BusinessMan();

        if ($this->getServer("REQUEST_METHOD") == "POST") {
            header('Content-Type: application/json');
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

            $requiredFields = $currentUser->user_type == "designer" ?
                [
                    "csrf_token",
                    "csrfToken",
                    "documentData",
                    "biographyData",
                    "goalsData",
                    "qualificationsData",
                    "portfolioData",
                    "experienceData",
                    "positionData"
                ] :
                [
                    "csrf_token",
                    "csrfToken",
                    "companyName",
                    "registerNumber",
                    "companyDescription",
                    "branchOfCompany"
                ];

            $post = $this->getRequestPost()
                ->setRequiredFields($requiredFields)
                ->configureDataPost()->getAllPostData();

            $oneThousendLengthValidation = [
                "biographyData",
                "goalsData",
                "qualificationsData",
                "portfolioData",
                "experienceData",
                "companyDescription"
            ];

            foreach ($post as $key => $value) {
                if (in_array($key, $oneThousendLengthValidation)) {
                    if (strlen($value) > 1000) {
                        echo json_encode([
                            "invalid_length" => true,
                            "msg" => "Um dos campos utrapassa o limite de caracteres."
                        ]);
                        die;
                    }
                }
            }

            if ($currentUser->user_type == "designer") {
                $personObject->setEmail($this->getCurrentSession()->login_user->fullEmail);
                $personObject->setDocument($post["documentData"]);
                $personObject->setBiography($post["biographyData"]);
                $personObject->setGoals($post["goalsData"]);
                $personObject->setQualifications($post["qualificationsData"]);
                $personObject->setPortfolio($post["portfolioData"]);
                $personObject->setExperience($post["experienceData"]);
                $personObject->setPositionData($post["positionData"]);
                $personObject->updateAdditionalData();
            } else {
                $personObject->setEmail($this->getCurrentSession()->login_user->fullEmail);
                $personObject->setCompanyName($post["companyName"]);
                $personObject->setRegisterNumber($post["registerNumber"]);
                $personObject->setDescriptionCompany($post["companyDescription"]);
                $personObject->setBranchOfCompany($post["branchOfCompany"]);
                $personObject->setValidCompany(true);
                $personObject->updateAdditionalData();
            }

            echo json_encode(["success" => true, "url" => url("/braid-system/my-profile")]);
            die;
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
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $csrfToken = $this->getCurrentSession()->csrf_token;

        $personData = $currentUser->user_type == "designer" ?
            $personObject->getDesignerByEmail($this->getCurrentSession()->login_user->fullEmail) :
            $personObject->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

        echo $this->view->render("admin/additional-data", [
            "personData" => $personData,
            "csrfToken" => $csrfToken,
            "menuSelected" => $menuSelected,
            "breadCrumbTitle" => "Dados adicionais",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function myProfile()
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $user = new User();
        $designer = new Designer();
        $businessMan = new BusinessMan();

        $menuSelected = removeQueryStringFromEndpoint($this->getServer("REQUEST_URI"));
        $menuSelected = explode("/", $menuSelected);
        $menuSelected = array_filter($menuSelected, function ($item) {
            if (!empty($item)) {
                return $item;
            }
        });
        $menuSelected = array_values($menuSelected);
        $menuSelected = $menuSelected[count($menuSelected) - 1];
        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

        $profileData = $userData->user_type == "designer" ?
            $designer->getDesignerByEmail($this->getCurrentSession()->login_user->fullEmail) :
            $businessMan->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

        if (empty($profileData)) {
            $profileData = $businessMan->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);
        }

        if (empty($profileData)) {
            redirect("/braid-system/client-report");
        }

        $profileType = $user->getUserByEmail($profileData->full_email);
        $evaluationDesigner = new EvaluationDesigner();
        $evaluationDesignerData = $evaluationDesigner->getEvaluationLeftJoinDesigner($profileData->full_email, 3, 0, true);
        $arrayEvaluationDesigner = $evaluationDesigner->getEvaluationLeftJoinDesigner($profileData->full_email);

        if (!empty($arrayEvaluationDesigner)) {
            foreach ($arrayEvaluationDesigner as &$ratingData) {
                $ratingData = $ratingData->rating_data;
            }
        } else {
            $arrayEvaluationDesigner = [];
        }

        $meanEvaluation = empty($arrayEvaluationDesigner) ?
            0 : round(array_sum($arrayEvaluationDesigner) / count($arrayEvaluationDesigner));

        $positionData = $profileType->user_type == "designer" ?
            $profileData->position_data : $profileData->company_name;

        echo $this->view->render("admin/my-profile", [
            "positionData" => $positionData,
            "totalEvaluationDesigner" => count($arrayEvaluationDesigner),
            "meanEvaluation" => $meanEvaluation,
            "evaluationDesignerData" => $evaluationDesignerData,
            "profileType" => $profileType,
            "profileData" => $profileData,
            "menuSelected" => $menuSelected,
            "breadCrumbTitle" => "Detalhes do perfil",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function chargeOnDemandEvaluation(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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

        if (empty($data["profile_email"])) {
            header("HTTP/1.1 500 Internal Server Error");
            throw new \Exception(json_encode($errorMessage));
        }

        $user = new User();
        $user->getUserByEmail($data["profile_email"]);

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

        $offsetValue = ($data["page"] * $data["max"]) - $data["max"];
        $evaluationDesigner = new EvaluationDesigner();
        $evaluationDesignerData = $evaluationDesigner->getEvaluationLeftJoinDesigner($data["profile_email"], $data["max"], $offsetValue, true);
        $totalEvaluationDesigner = $evaluationDesigner->getEvaluationLeftJoinDesigner($data["profile_email"]);

        if (!empty($evaluationDesignerData)) {
            foreach ($evaluationDesignerData as &$evaluationData) {
                $evaluationData = $evaluationData->data();
            }
        }
        $evaluationDesignerData[]["total_evaluation"] = count($totalEvaluationDesigner);

        echo json_encode($evaluationDesignerData);
        die;
    }

    public function profileData(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

        $designer = new Designer();
        $businessMan = new BusinessMan();
        $evaluationDesigner = new EvaluationDesigner();
        $user = new User();

        if ($this->getServer("REQUEST_METHOD") == "POST") {
            header('Content-Type: application/json');

            if (!isset($this->getAllServerData()["HTTP_AUTHORIZATION"])) {
                throw new \Exception("Cabeçalho de autorização ausente");
            }

            if (strpos($this->getAllServerData()["HTTP_AUTHORIZATION"], 'Bearer ') !== 0) {
                throw new \Exception("Formato de autorização inválido.");
            }

            $profileEmail = str_replace("Bearer ", "", $this->getAllServerData()["HTTP_AUTHORIZATION"]);
            $profileEmail = base64_decode($profileEmail, true);

            if (!$profileEmail) {
                header("HTTP/1.1 403 Forbidden");
                echo json_encode(["error" => "Acesso negado"]);
                die;
            }

            if (!isEmail($profileEmail)) {
                header("HTTP/1.1 403 Forbidden");
                echo json_encode(["error" => "Acesso negado"]);
                die;
            }

            $post = $this->getRequestPost()
                ->setRequiredFields(["evaluateDescription", "csrf_token", "csrfToken"])
                ->configureDataPost()->getAllPostData();

            $fb = empty($post["fb"]) ? 0 : $post["fb"];

            $designerData = $designer->getDesignerByEmail($profileEmail);
            $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

            if ($userData->user_type != "businessman") {
                throw new \Exception("Somente usuários do tipo empresa podem enviar avaliações");
            }

            $businessManData = $businessMan->getBusinessManByEmail($userData->full_email);
            if (!empty($designerData)) {

                $designer->setId($designerData->id);
                $businessMan->setId($businessManData->id);
                $evaluationDesigner->setDesigner($designer);
                $evaluationDesigner->setBusinessMan($businessMan);
                $evaluationDesigner->setRatingData($fb);
                $evaluationDesigner->setEvaluationDescription($post["evaluateDescription"]);
                $evaluationDesigner->setEvaluationDesigner($evaluationDesigner);

                echo json_encode([
                    "success" => true,
                    "rating" => $evaluationDesigner->getRatingData(),
                    "evaluation_description" => $evaluationDesigner->getEvaluationDescription()
                ]);
                die;
            }
        }

        $profileEmail = base64_decode($data["hash"], true);
        if (!$profileEmail) {
            redirect("braid-system/my-profile");
        }

        if (!isValidEmail($profileEmail)) {
            redirect("braid-system/my-profile");
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

        $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);
        $profileData = $designer->getDesignerByEmail($profileEmail);

        if (empty($profileData)) {
            redirect("/braid-system/my-profile");
        }

        $csrfToken = $this->getCurrentSession()->csrf_token;
        $arrayEvaluationDesigner = $evaluationDesigner->getEvaluationLeftJoinDesigner($profileData->full_email);
        $evaluationDesignerData = $evaluationDesigner->getEvaluationLeftJoinDesigner($profileData->full_email, 3, 0, true);
        $isEvaluatedByBusinessMan = false;

        if (!empty($evaluationDesignerData)) {
            foreach ($evaluationDesignerData as &$evaluationData) {
                $evaluationData = $evaluationData->data();
            }
        }

        if (!empty($arrayEvaluationDesigner)) {
            $businessManData = $businessMan->getBusinessManByEmail($this->getCurrentSession()->login_user->fullEmail);

            foreach ($arrayEvaluationDesigner as &$dataMeanEvaluation) {
                if (!empty($businessManData)) {
                    if ($dataMeanEvaluation->business_man_id == $businessManData->id) {
                        $isEvaluatedByBusinessMan = true;
                    }
                }
                $dataMeanEvaluation = $dataMeanEvaluation->rating_data;
            }

            $meanEvaluation = round(array_sum($arrayEvaluationDesigner) / count($arrayEvaluationDesigner));

            if ($meanEvaluation > 5) {
                $meanEvaluation = 5;
            }
        } else {
            $meanEvaluation = 0;
        }

        $breadCrumbBefore = [
            "slug" => "Detalhes do projeto",
            "url" => $this->getCurrentSession()->linkBreadCrumbBefore
        ];

        echo $this->view->render("admin/profile-data", [
            "breadCrumbBefore" => $breadCrumbBefore,
            "positionData" => $profileData->position_data,
            "isEvaluatedByBusinessMan" => $isEvaluatedByBusinessMan,
            "totalEvaluationDesigner" => count($arrayEvaluationDesigner),
            "meanEvaluation" => $meanEvaluation,
            "evaluationDesignerData" => $evaluationDesignerData,
            "csrfToken" => $csrfToken,
            "profileData" => $profileData,
            "menuSelected" => $menuSelected,
            "breadCrumbTitle" => "Detalhes do perfil",
            "fullName" => $userData->full_name,
            "fullEmail" => $userData->full_email,
            "nickName" => $userData->nick_name,
            "pathPhoto" => $userData->path_photo,
            "userType" => $userData->user_type
        ]);
    }

    public function chargeOnDemandCandidates(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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

        $offsetValue = ($data["page"] * $data["max"]) - $data["max"];
        $response = [];

        $contract = new Contract();
        $contractData = $contract->getContractLeftJoinDesigner($data["job_id"]);
        $contractData = $contractData
            ->offset($offsetValue)->limit($data["max"])
            ->order("braid.contract.id", true)->fetch(true);

        foreach ($contractData as $contractValue) {
            array_push($response, $contractValue->data());
        }

        $response[] = ["total_contracts" => $contract->getTotalContractLeftJoinDesigner($data["job_id"])];
        echo json_encode($response);
        die;
    }

    public function projectDetail(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
            redirect("braid-system/my-profile");
        }

        if (!preg_match("/^\d+$/", $jobId)) {
            redirect("braid-system/my-profile");
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
        $csrfToken = $this->getCurrentSession()->csrf_token;

        if (empty($jobData)) {
            redirect("braid-system/my-profile");
        }

        echo $this->view->render("admin/project-detail", [
            "csrfToken" => $csrfToken,
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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
            $contract = new Contract();

            $jobs->setId($jobId);
            $contract->setJobs($jobs);

            $contract->destroyContractByJob();
            $jobs->deleteJobs();

            echo json_encode(["success_delete_project" => true, "id" => $jobId]);
        }
    }

    public function editProject(array $data = [])
    {
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
                "url" => url("braid-system/my-profile")
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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
                redirect("/braid-system/my-profile");
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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
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
        if (empty($this->getCurrentSession()->login_user)) {
            redirect("/user/login");
        }

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
            $userData = $user->getUserByEmail($this->getCurrentSession()->login_user->fullEmail);

            if (!empty($userData)) {
                if ($userData->user_type == "designer") {
                    $designer = new Designer();
                    $designer->updateNameEmailPhotoDesigner($post);
                } else {
                    $businessMan = new BusinessMan();
                    $businessMan->updateNameEmailPhotoBusinessMan($post);
                }
            }

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
