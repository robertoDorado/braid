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
    /** @var BusinessMan */
    private BusinessMan $businessMan;

    /** @var Designer */
    private Designer $designer;

    /** @var Jobs */
    private Jobs $jobs;

    /** @var ModelosContract Modelo de contrato para persistência */
    private ModelsContract $contract;

    /** @var string Descrições adicionais sobre o trabalho que será feito */
    private string $additionalDescription;

    /** @var bool Assinatura do contratante */
    private bool $signatureBusinessMan;

    /** @var bool Assinatura do contratado */
    private bool $signatureDesigner;

    public function setModelContract(Contract $obj)
    {
        $getter = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getter) && is_array($isMethods)) {
            $this->contract = new ModelsContract();
            $this->contract->designer_id = $this->getDesigner()->getId();
            $this->contract->business_man_id = $this->getBusinessMan()->getId();
            $this->contract->job_id = $this->getJobs()->getId();
            $this->contract->additional_description = $this->getAdditionalDescription();
            $this->contract->signature_business_man = empty($this->getSignatureBusinessMan()) ? 0 : 1;
            $this->contract->signature_designer = empty($this->getSignatureDesigner()) ? 0 : 1;
            if (!$this->contract->save()) {
                throw new \Exception($this->contract->fail());
            }
        }
    }

    public function getContractLeftJoinDesigner(int $jobId)
    {
        $this->contract = new ModelsContract();
        $contractData = $this->contract
        ->find("job_id=:job_id", ":job_id=" . $jobId . "", "additional_description")
        ->advancedLeftJoin("designer", 
        "braid.designer.id = braid.contract.designer_id", null, null, "full_name, path_photo")
        ->fetch(true);

        return $contractData;
    }

    public function getContractByDesignerIdAndJobId(int $designerId, int $jobId)
    {
        $this->contract = new ModelsContract();
        $contractData = $this->contract->find("designer_id=:designer_id AND job_id=:job_id",
        ":designer_id=" . $designerId . "&:job_id=" . $jobId . "")->fetch();

        return $contractData;
    }

    public function getAdditionalDescription()
    {
        return $this->additionalDescription;
    }

    public function setAdditionalDescription(string $description)
    {
        $this->additionalDescription = $description;
    }

    public function getJobs()
    {
        return $this->jobs;
    }

    public function setJobs(Jobs $jobs)
    {
        $this->jobs = $jobs;
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

    public function setSignatureBusinessMan(bool $signature)
    {
        $this->signatureBusinessMan = $signature;
    }

    public function getSignatureBusinessMan()
    {
        return $this->signatureBusinessMan;
    }

    public function setSignatureDesigner(bool $signature)
    {
        $this->signatureDesigner = $signature;
    }

    public function getSignatureDesigner()
    {
        return $this->signatureDesigner;
    }
}