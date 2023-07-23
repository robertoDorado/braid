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
    private string $ceoName;

    /** @var string Nome da empresa */
    private string $companyName;

    /** @var string CNPJ da empresa */
    private string $registerNumber;

    /** @var string Descrição da empresa */
    private string $companyDescription;

    /** @var string Ramo da empresa */
    private string $branchOfCompany;

    /** @var Contract[] Contratos */
    private array $contracts;

    /** @var bool */
    private bool $validCompany;

    /** @var ModelsBusinessMan Objeto BusinessMan */
    private ModelsBusinessMan $businessMan;

    public function  setModelBusinessMan(BusinessMan $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->businessMan = new ModelsBusinessMan();
            $this->businessMan->name = $this->getCeoName();
            $this->businessMan->company_name = $this->getCompanyName();
            $this->businessMan->register_number = $this->getRegisterNumber();
            $this->businessMan->company_description = $this->getDescriptionCompany();
            $this->businessMan->branch_of_company = $this->getBranchOfCompany();
            $this->businessMan->valid_company = $this->isValidCompany();
            if (!$this->businessMan->save()) {
                throw new \Exception($this->businessMan->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function getId()
    {
        if (empty($this->id)) {
            return null;
        }
        return $this->id;
    }

    public function setCeoName(string $ceoName)
    {
        $this->ceoName = $ceoName;
    }

    public function getCeoName(): string
    {
        return $this->ceoName;
    }

    public function getCompanyName(): string
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

    public function getDescriptionCompany(): string
    {
        return $this->companyDescription;
    }

    public function setDescriptionCompany(string $companyDescription)
    {
        $this->companyDescription = $companyDescription;
    }

    public function getBranchOfCompany(): string
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

    public function isValidCompany(): bool
    {
        return $this->validCompany;
    }

    public function setValidCompany(bool $validCompany)
    {
        $this->validCompany = $validCompany;
    }
}