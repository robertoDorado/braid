<?php
namespace Source\Domain\Model;

/**
 * Jobs Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Jobs
{
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