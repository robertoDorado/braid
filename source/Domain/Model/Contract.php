<?php

namespace Source\Domain\Model;

/**
 * Contract Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Contract
{
    /** @var string[] Trabalhos que serão realizados */
    private array $jobs;

    /** @var string[] Descrição dos trabalhos que serão realizados */
    private array $jobsDescription;

    /** @var string Prazo e horário de trabalho */
    private string $timestampJobs;

    /** @var float Valor do acordo de pagamento (remuneração) */
    private float $remuneration;

    /** @var string Definição da propiedade intelectual */
    private string $intellectualProperty;

    /** @var string Definição de confidencialidade */
    private string $confidentiality;

    /** @var string Rescisão do contrato */
    private string $terminationOfContract;

    /** @var string Clausulas adicionais */
    private string $additionalClauses;

    /** @var string Assinatura do contratante */
    private string $signatureBusinessMan;

    /** @var string Assinatura do contratado */
    private string $signatureDesigner;

    /** @var BusinessMan */
    private BusinessMan $businessMan;

    /** @var Designer */
    private Designer $designer;

    public function setJobs(array $jobs)
    {
        $this->jobs = $jobs;
    }

    public function getJobs(): array
    {
        return $this->jobs;
    }

    public function setJobsDescription(array $jobsDescription)
    {
        $this->jobsDescription = $jobsDescription;
    }

    public function getJobsDescription(): array
    {
        return $this->jobsDescription;
    }

    public function setTimestampJobs(string $timestampJobs)
    {
        $this->timestampJobs = $timestampJobs;
    }

    public function getTimestampJobs(): string
    {
        return $this->timestampJobs;
    }

    public function setRemuneration(float $remuneration)
    {
        $this->remuneration = $remuneration;
    }

    public function getRemuneration(): float
    {
        return $this->remuneration;
    }

    public function setIntellectualProperty(string $intellectualProperty)
    {
        $this->intellectualProperty = $intellectualProperty;
    }

    public function getIntellectualProperty(): string
    {
        return $this->intellectualProperty;
    }

    public function setConfidentiality(string $confidentiality)
    {
        $this->confidentiality = $confidentiality;
    }

    public function getConfidentiality(): string
    {
        return $this->confidentiality;
    }

    public function setTerminationOfContract(string $terminationOfContract)
    {
        $this->terminationOfContract = $terminationOfContract;
    }

    public function getTerminationOfContract(): string
    {
        return $this->terminationOfContract;
    }

    public function setAdditionalClauses(string $additionalClauses)
    {
        $this->additionalClauses = $additionalClauses;
    }

    public function getAdditionalClauses(): string
    {
        return $this->additionalClauses;
    }

    public function setDesigner(Designer $designer)
    {
        $this->designer = $designer;
    }

    public function getDesigner(): Designer
    {
        return $this->designer;
    }

    public function setBusinessMan(BusinessMan $businessMan)
    {
        $this->businessMan = $businessMan;
    }

    public function getBusinessMan(): BusinessMan
    {
        return $this->businessMan;
    }

    public function setSignatureBusinessMan(string $signature)
    {
        $this->signatureBusinessMan = $signature;
    }

    public function getSignatureBusinessMan()
    {
        return $this->signatureBusinessMan;
    }

    public function setSignatureDesigner(string $signature)
    {
        $this->signatureDesigner = $signature;
    }

    public function getSignatureDesigner()
    {
        return $this->signatureDesigner;
    }
}
