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
    private int $id = 0;

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

    public function countTotalJobsByBusinessManId(int $id)
    {
        $this->jobs = new ModelsJobs();
        $totalRegisters = $this->jobs
        ->find("business_man_id=:business_man_id", ":business_man_id=" . $id . "")
        ->count();

        return $totalRegisters;
    }

    public function getJobsByBusinessManId(int $id, int $limitValue = 0, int $offsetValue = 0)
    {
        $this->jobs = new ModelsJobs();

        $jobs = $this->jobs->find("business_man_id=:business_man_id",
        ":business_man_id=" . $id . "");

        if (!empty($limitValue)) {
            $jobs->limit($limitValue);
        }

        if (!empty($offsetValue)) {
            $jobs->offset($offsetValue);
        }
        
        return $jobs->fetch(true);
    }

    public function convertCurrencyRealToFloat(string $value)
    {
        if (empty($value)) {
            throw new \Exception("Valor a ser convertido não pode estar vazio.");
        }

        $value = str_replace("&nbsp;", "", $value);
        $value = str_replace(["R$", "."], "", $value);
        $value = str_replace(",", ".", $value);
        $value = floatval($value);

        return $value;
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