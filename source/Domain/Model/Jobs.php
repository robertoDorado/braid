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

    /** @var BusinessMan Chave de relacionamento BusinessMan */
    private BusinessMan $businessman;

    private ModelsJobs $jobs;

    public function setModelJob(Jobs $jobs)
    {
        $getters = checkGettersFilled($jobs);
        $isMethods = checkIsMethodsFilled($jobs);

        if (is_array($getters) && is_array($isMethods)) {
            $this->jobs = new ModelsJobs();
            $this->jobs->business_man_id = $this->getBusinessMan()->getId();
            $this->jobs->job_name = $this->getJobName();
            $this->jobs->job_description = $this->getJobDescription();
            $this->jobs->remuneration_data = $this->getRemuneration();
            $this->jobs->delivery_time = $this->getDeliveryTime();
            if (!$this->jobs->save()) {
                if (!empty($this->jobs->fail())) {
                    throw new \PDOException($this->jobs->fail()->getMessage());
                }else {
                    throw new \PDOException($this->jobs->message());
                }
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function deleteJobById(int $id)
    {
        $this->jobs = new ModelsJobs();
        $job = $this->jobs->findById($id);

        if (empty($job)) {
            throw new \Exception("Projeto não identificado");
        }

        if (!$job->destroy()) {
            if (!empty($job->fail())) {
                throw new \PDOException($job->fail()->getMessage());
            }else {
                throw new \PDOException($job->message());
            }
        }
    }

    public function updateJobById(array $post): bool
    {
        $this->jobs = new ModelsJobs();
        $jobData = $this->jobs->findById($post["id"]);

        if (empty($jobData)) {
            throw new \Exception("Registro do projeto inexistente");
        }

        $jobData->job_name = $post["jobName"];
        $jobData->job_description = $post["jobDescription"];
        $jobData->remuneration_data = $post["remunerationData"];
        $jobData->delivery_time = $post["deliveryTime"];
        if (!$jobData->save()) {
            if (!empty($jobData->fail())) {
                throw new \PDOException($jobData->fail()->getMessage());
            }else {
                throw new \PDOException($jobData->message());
            }
        }

        return true;
    }

    public function getJobsById(int $id)
    {
        return (new ModelsJobs())->findById($id);
    }

    public function getJobsLikeQuery(array $data, int $limit = 0)
    {
        $this->jobs = new ModelsJobs();
        $jobsData = $this->jobs->getJobsWithCandidatesLikeQuery($data, $limit);
        return $jobsData;
    }

    public function countTotalJobs()
    {
        $this->jobs = new ModelsJobs();
        $totalJobs = $this->jobs->find("")->count();
        return $totalJobs;
    }

    public function getAllJobs(int $limitValue = 0, int $offsetValue = 0, bool $orderBy = false, bool $hashId = false)
    {
        $this->jobs = new ModelsJobs();
        $jobsData = $this->jobs->getJobsWithCandidates(0, $limitValue, $offsetValue, $orderBy, $hashId);
        return $jobsData;
    }

    public function countTotalJobsByBusinessManId(int $id)
    {
        $this->jobs = new ModelsJobs();
        $totalRegisters = $this->jobs
        ->find("business_man_id=:business_man_id", ":business_man_id=" . $id . "")
        ->count();

        return $totalRegisters;
    }

    public function getJobsByBusinessManId(int $id, int $limitValue = 0, int $offsetValue = 0, bool $orderBy = false, bool $hashId = false)
    {
        $this->jobs = new ModelsJobs();

        $jobsData = $this->jobs->getJobsWithCandidates($id, $limitValue, $offsetValue, $orderBy, $hashId);
        return $jobsData;
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
        $this->businessman = $businessMan;
    }

    public function getBusinessMan()
    {
        return $this->businessman;
    }
}