<?php

namespace Source\Domain\Model;

use Bissolli\ValidadorCpfCnpj\CNPJ;
use Source\Core\Connect;
use Source\Models\BusinessMan as ModelsBusinessMan;

/**
 * BusinessMan Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class BusinessMan
{
    /** @var int Ultimo id inserido no banco */
    private int $id;

    /** @var string Nome do dono da empresa */
    private string $fullName;

    /** @var string Email do dono da empresa */
    private string $fullEmail = '';

    /** @var string Foto */
    private string $pathPhoto = '';

    /** @var string Nome da empresa */
    private string $companyName = '';

    /** @var string CNPJ da empresa */
    private string $registerNumber = '';

    /** @var string Descrição da empresa */
    private string $companyDescription = '';

    /** @var string Ramo da empresa */
    private string $branchOfCompany = '';

    /** @var Contract[] Contratos */
    private array $contracts = [];

    /** @var bool */
    private bool $validCompany = false;

    /** @var ModelsBusinessMan Objeto BusinessMan */
    private ModelsBusinessMan $businessMan;

    public function setModelBusinessMan(BusinessMan $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->businessMan = new ModelsBusinessMan();
            $this->businessMan->full_name = $this->getCeoName();
            $this->businessMan->full_email = $this->getEmail();
            $this->businessMan->path_photo = empty($this->getPathPhoto()) ? null : $this->getPathPhoto();
            $this->businessMan->company_name = empty($this->getCompanyName()) ? null : $this->getCompanyName();
            $this->businessMan->register_number = empty($this->getRegisterNumber()) ? null : $this->getRegisterNumber();
            $this->businessMan->company_description = empty($this->getDescriptionCompany()) ? null : $this->getDescriptionCompany();
            $this->businessMan->branch_of_company = empty($this->getBranchOfCompany()) ? null : $this->getBranchOfCompany();
            $this->businessMan->valid_company = empty($this->isValidCompany()) ? null : $this->isValidCompany();
            if (!$this->businessMan->save()) {
                if (!empty($this->businessMan->fail())) {
                    throw new \PDOException($this->businessMan->fail()->getMessage() . " " . $this->businessMan->queryExecuted());
                }else {
                    throw new \PDOException($this->businessMan->message());
                }
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function updateAdditionalData()
    {
        $this->businessMan = new ModelsBusinessMan();
        $businessManData = $this->businessMan
            ->find("full_email=:full_email", ":full_email=" . $this->getEmail() . "")
            ->fetch();
        
        if (empty($businessManData)) {
            throw new \Exception("Objeto businessMan não encontrado");
        }

        $businessManData->company_name = $this->getCompanyName();
        $businessManData->register_number = $this->getRegisterNumber();
        $businessManData->company_description = $this->getDescriptionCompany();
        $businessManData->branch_of_company = $this->getBranchOfCompany();
        $businessManData->valid_company = !$this->isValidCompany() ? 0 : 1;
        if (!$businessManData->save()) {
            if (!empty($businessManData->fail())) {
                throw new \PDOException($businessManData->fail()->getMessage() . " " . $businessManData->queryExecuted());
            }else {
                throw new \PDOException($businessManData->message());
            }
        }
    }

    public function updateNameEmailPhotoBusinessMan(array $data)
    {
        $this->businessMan = new ModelsBusinessMan();
        $businessManData = $this->businessMan
            ->find("full_email=:full_email", ":full_email=" . $data["fullEmail"] . "")->fetch();
        
        if (empty($businessManData)) {
            throw new \Exception("Objeto businessMan não encontrado");
        }

        $businessManData->full_name = $data["fullName"];
        $businessManData->full_email = $data["fullEmail"];
        $businessManData->path_photo = $data["pathPhoto"];
        if (!$businessManData->save()) {
            if (!empty($businessManData->fail())) {
                throw new \PDOException($businessManData->fail()->getMessage() . " " . $businessManData->queryExecuted());
            }else {
                throw new \PDOException($businessManData->message());
            }
        }
    }

    public function getPathPhoto()
    {
        return $this->pathPhoto;
    }

    public function setPathPhoto(string $pathPhoto)
    {
        $this->pathPhoto = $pathPhoto;
    }

    public function getBusinessManById(int $id)
    {
        return (new ModelsBusinessMan())->findById($id);
    }

    public function getBusinessManByEmail(string $email)
    {
        $this->businessMan = new ModelsBusinessMan();
        $businessMan = $this->businessMan
        ->find("full_email=:full_email", ":full_email=" . $email . "")
        ->fetch();

        return $businessMan;
    }

    public function getTotalData()
    {
        $this->businessMan = new ModelsBusinessMan();
        return $this->businessMan->find('')->count();
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        if (empty($this->id)) {
            return null;
        }
        return $this->id;
    }

    public function setCeoName(string $name)
    {
        $this->fullName = $name;
    }

    public function getCeoName()
    {
        return $this->fullName;
    }

    public function setEmail(string $email)
    {
        $emailData = (new ModelsBusinessMan())
            ->find('full_email=:full_email', ':full_email=' . $email . '', 'email')
            ->fetch();

        if (!empty($emailData)) {
            echo json_encode(['email_already_exists' => true]);
            die;
        }
        $this->fullEmail = $email;
    }

    public function getEmail()
    {
        return $this->fullEmail;
    }

    public function getCompanyName()
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName)
    {
        $this->companyName = $companyName;
    }

    public function getRegisterNumber()
    {
        return $this->registerNumber;
    }

    public function setRegisterNumber(string $number)
    {
        if (!preg_match("/^(\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2})$/", $number)) {
            echo json_encode([
                "invalid_document" => true,
                "msg" => "CNPJ inválido"
            ]);
            die;
        }

        $document = new CNPJ($number);
        if (!$document->isValid()) {
            echo json_encode([
                "invalid_document" => true,
                "msg" => "CNPJ inválido"
            ]);
            die;
        }

        $this->registerNumber = $number;
    }

    public function getDescriptionCompany()
    {
        return $this->companyDescription;
    }

    public function setDescriptionCompany(string $companyDescription)
    {
        $this->companyDescription = $companyDescription;
    }

    public function getBranchOfCompany()
    {
        return $this->branchOfCompany;
    }

    public function setBranchOfCompany(string $branchOfCompany)
    {
        $this->branchOfCompany = $branchOfCompany;
    }

    /**
     * @return Contract[]
     */
    public function getContracts()
    {
        if (empty($this->contracts)) {
            return null;
        }
        return $this->contracts;
    }

    public function setContract(Contract $contract)
    {
        $this->contracts[] = $contract;
    }

    public function isValidCompany()
    {
        return $this->validCompany;
    }

    public function setValidCompany(bool $validCompany)
    {
        $this->validCompany = $validCompany;
    }
}
