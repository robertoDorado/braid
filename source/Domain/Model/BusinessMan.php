<?php

namespace Source\Domain\Model;

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
