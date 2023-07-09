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
    /** @var string Nome da empresa */
    private string $companyName;

    /** @var string Descrição da empresa */
    private string $companyDescription;

    /** @var string Ramo da empresa */
    private string $branchOfCompany;

    /** @var string Descrição do trabalho */
    private string $jobDescrpiption;

    /** @var float Valor de pagamento */
    private float $paymentValue;

    /** @var Contract[] Contratos */
    private array $contracts;

    /** @var bool */
    private bool $validCompany;

    /**
     * BusinessMan constructor
     */
    public function __construct(string $companyName = '', string $companyDescription = '', string $branchOfCompany = '', string $jobDescrpiption = '', float $paymentValue = 0, bool $validCompany = false)
    {
        $this->companyName = $companyName;
        $this->companyDescription = $companyDescription;
        $this->branchOfCompany = $branchOfCompany;
        $this->jobDescrpiption = $jobDescrpiption;
        $this->paymentValue = $paymentValue;
        $this->validCompany = $validCompany;
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

    public function getPaymentValue(): float
    {
        return $this->paymentValue;
    }

    public function setPaymentValue(float $paymentValue)
    {
        $this->paymentValue = $paymentValue;
    }

    /**
     * @return Contract[]
     */
    public function getContracts()
    {
        return $this->contracts;
    }

    public function setContract(int $id, Contract $contract)
    {
        $this->contracts[$id] = $contract;
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