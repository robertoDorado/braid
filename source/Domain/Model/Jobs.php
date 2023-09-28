<?php
namespace Source\Domain\Model;

use Source\Core\Connect;
use Source\Models\Jobs as ModelsJobs;

/**
 * Jobs Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Jobs
{
    /** @var int */
    private int $id;

    /** @var string Nome da tarefa/trabalho a ser realizado */
    private string $jobName;

    /** @var string Descrição da tarefa a se realizada */
    private string $jobDescription;

    /** @var float Valor de remuneração */
    private float $remuneration;

    /** @var string Tempo máximo para entrega */
    private string $deliveryTime;

    /** @var BusinessMan[] Chave de relacionamento BusinessMan */
    private array $businessman;

    private ModelsJobs $jobs;

    public function setModelJob(Jobs $jobs, BusinessMan $businessMan)
    {
        $getters = checkGettersFilled($jobs);
        $isMethods = checkIsMethodsFilled($jobs);

        if (is_array($getters) && is_array($isMethods)) {
            $this->jobs = new ModelsJobs();
            $this->jobs->business_man_id = $businessMan->getId();
            $this->jobs->job_name = $this->getJobName();
            $this->jobs->job_description = $this->getJobDescription();
            $this->jobs->remuneration_data = $this->getRemuneration();
            $this->jobs->delivery_time = $this->getDeliveryTime();
            if (!$this->jobs->save()) {
                throw new \Exception($this->jobs->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setJobName(string $jobName)
    {
        $this->jobName = $jobName;
    }

    public function getJobName()
    {
        return $this->jobName;
    }

    public function setJobDescription(string $jobDescription)
    {
        $this->jobDescription = $jobDescription;
    }

    public function getJobDescription()
    {
        return $this->jobDescription;
    }

    public function setRemuneration(float $remuneration)
    {
        return $this->remuneration = $remuneration;
    }

    public function getRemuneration()
    {
        return $this->remuneration;
    }

    public function setDeliveryTime(string $deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;
    }

    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    public function setBusinessMan(BusinessMan $businessMan)
    {
        $this->businessman[] = $businessMan;
    }

    public function getBusinessMan()
    {
        return $this->businessman;
    }
}