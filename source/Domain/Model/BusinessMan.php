<?php

namespace Source\Domain\Model;

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

    public function  setModelBusinessMan(BusinessMan $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->businessMan = new ModelsBusinessMan();
            $this->businessMan->full_name = $this->getCeoName();
            $this->businessMan->full_email = $this->getEmail();
            $this->businessMan->company_name = empty($this->getCompanyName()) ? null : $this->getCompanyName();
            $this->businessMan->register_number = empty($this->getRegisterNumber()) ? null : $this->getRegisterNumber();
            $this->businessMan->company_description = empty($this->getDescriptionCompany()) ? null : $this->getDescriptionCompany();
            $this->businessMan->branch_of_company = empty($this->getBranchOfCompany()) ? null : $this->getBranchOfCompany();
            $this->businessMan->valid_company = empty($this->isValidCompany()) ? null : $this->isValidCompany();
            if (!$this->businessMan->save()) {
                throw new \Exception($this->businessMan->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function getTotalData()
    {
        $this->businessMan = new ModelsBusinessMan();
        return $this->businessMan->find('')->count();
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
            throw new \Exception("Número de CNPJ inválido");
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