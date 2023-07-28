<?php

namespace Source\Domain\Model;
use Source\Models\Contract as ModelsContract;

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

    /** @var ModelosContract Modelo de contrato para persistência */
    private ModelsContract $contract;

    /** @var string Valor cobrado pela braid com base no valor do contrato (taxa de 1%) */
    private float $billingAmount;

    public function setModelContract(Contract $obj)
    {
        $getter = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getter) && is_array($isMethods)) {
            $this->contract = new ModelsContract();
            $this->contract->designer_id = $this->getDesigner()->getId();
            $this->contract->businessman_id = $this->getBusinessMan()->getId();
            $this->contract->jobs = $this->getJobsAsString();
            $this->contract->jobs_description = $this->getJobsDescriptionAsString();
            $this->contract->timestamp_jobs = $this->getTimestampJobs();
            $this->contract->remuneration = $this->getRemuneration();
            $this->contract->intellectual_property = $this->getIntellectualProperty();
            $this->contract->confidentiality = $this->getConfidentiality();
            $this->contract->termination_of_contract = $this->getTerminationOfContract();
            $this->contract->additional_clauses = $this->getAdditionalClauses();
            $this->contract->signature_businessman = $this->getSignatureBusinessMan();
            $this->contract->signature_designer = $this->getSignatureDesigner();
            $this->contract->billing_amount = $this->getBillingAmount();
            if (!$this->contract->save()) {
                throw new \Exception($this->contract->fail());
            }
        }
    }

    public function getBillingAmount()
    {
        return $this->billingAmount;
    }

    public function setBillingAmount(float $amount)
    {
        $this->billingAmount = $amount;
    }

    public function setJobs(array $jobs)
    {
        $this->jobs = $jobs;
    }

    public function getJobs(): array
    {
        return $this->jobs;
    }

    public function getJobsAsString(): string
    {
        if (!empty($this->jobs)) {
            $jobs = implode(";", $this->jobs);
            return $jobs;
        }
    }

    public function setJobsDescription(array $jobsDescription)
    {
        $this->jobsDescription = $jobsDescription;
    }

    public function getJobsDescription(): array
    {
        return $this->jobsDescription;
    }

    public function getJobsDescriptionAsString(): string
    {
        if (!empty($this->jobsDescription)) {
            $jobs = implode(";", $this->jobsDescription);
            return $jobs;
        }
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

    public function getIntellectualProperty()
    {
        if (empty($this->intellectualProperty)) {
            return null;
        }

        return $this->intellectualProperty;
    }

    public function setConfidentiality(string $confidentiality)
    {
        $this->confidentiality = $confidentiality;
    }

    public function getConfidentiality()
    {
        if (empty($this->confidentiality)) {
            return null;
        }
        return $this->confidentiality;
    }

    public function setTerminationOfContract(string $terminationOfContract)
    {
        $this->terminationOfContract = $terminationOfContract;
    }

    public function getTerminationOfContract()
    {
        if (empty($this->terminationOfContract)) {
            return null;
        }
        return $this->terminationOfContract;
    }

    public function setAdditionalClauses(string $additionalClauses)
    {
        $this->additionalClauses = $additionalClauses;
    }

    public function getAdditionalClauses()
    {
        if (empty($this->additionalClauses)) {
            return null;
        }
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