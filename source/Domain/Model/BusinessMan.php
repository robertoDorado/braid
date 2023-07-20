<?php

namespace Source\Domain\Model;

use ReflectionClass;
use Source\Models\BusinessMan as ModelsBusinessMan;

/**
 * BusinessMan Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class BusinessMan
{
    /** @var string Nome do dono da empresa */
    private string $ceoName;

    /** @var string Nome da empresa */
    private string $companyName;

    /** @var string Descrição da empresa */
    private string $companyDescription;

    /** @var string Ramo da empresa */
    private string $branchOfCompany;

    /** @var string Descrição do trabalho */
    private string $jobDescrpiption;

    /** @var Contract[] Contratos */
    private array $contracts;

    /** @var bool */
    private bool $validCompany;

    /** @var ModelsBusinessMan Objeto BusinessMan */
    private ModelsBusinessMan $businessMan;

    public function  setModelBusinessMan(BusinessMan $obj)
    {
        $getters = $this->checkGettersFilled($obj);
        $isMethods = $this->checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->businessMan = new ModelsBusinessMan();
            $this->businessMan->name = $this->getCeoName();
            $this->businessMan->company_name = $this->getCompanyName();
            $this->businessMan->company_description = $this->getDescriptionCompany();
            $this->businessMan->branch_of_company = $this->getBranchOfCompany();
            $this->businessMan->job_description = $this->getJobDescription();
            $this->businessMan->valid_company = $this->isValidCompany();
            if (!$this->businessMan->save()) {
                throw new \Exception($this->businessMan->fail());
            }
        }
    }

    private function checkIsMethodsFilled(BusinessMan $obj)
    {
        $reflection = new ReflectionClass($obj);
        $isMethods = [];

        foreach ($reflection->getMethods() as $method) {
            if (strpos($method->name, 'is') === 0 && $method->getNumberOfParameters() === 0) {
                $propertyName = lcfirst(substr($method->name, 2));
                $isMethods[$propertyName] = $obj->{$method->name}();
            }
        }

        return $isMethods;
    }

    private function checkGettersFilled(BusinessMan $obj)
    {
        $reflection = new ReflectionClass($obj);
        $getters = [];

        foreach ($reflection->getMethods() as $method) {
            if (strpos($method->name, 'get') === 0 && $method->getNumberOfParameters() === 0) {
                $propertyName = lcfirst(substr($method->name, 3));
                $getters[$propertyName] = $obj->{$method->name}();
            }
        }

        return $getters;
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

    public function getJobDescription(): string
    {
        return $this->jobDescrpiption;
    }

    public function setJobDescription(string $jobDescrpiption)
    {
        $this->jobDescrpiption = $jobDescrpiption;
    }

    /**
     * @return Contract[]
     */
    public function getContracts()
    {
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
