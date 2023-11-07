<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Jobs Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Jobs extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".jobs";

    private string $businessManId = 'business_man_id';

    /** @var string Nome da tarefa/trabalho a ser realizado */
    private string $jobName = 'job_name';

    /** @var string Descrição da tarefa a se realizada */
    private string $jobDescription = 'job_description';

    /** @var string Valor de remuneração */
    private string $remunerationData = 'remuneration_data';

    /** @var string Tempo máximo para entrega */
    private string $deliveryTime = 'delivery_time';
    /**
     * Jobs constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->businessManId, $this->jobName, $this->jobDescription, $this->jobDescription, $this->remunerationData, $this->deliveryTime]);
    }

    public function getJobsWithCandidatesLikeQuery(array $data, int $limitValue = 0)
    {
        $terms = "";
        $params = "";

        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $terms .= "{$key} LIKE :{$key} OR ";
                $params .= "{$key}=%{$value}%&";
            }
        }

        $terms = removeLastStringOcurrence($terms, "OR");
        $params = removeLastStringOcurrence($params, "&");

        $sql = "SELECT jobs.id, jobs.business_man_id,
        COUNT(contract.designer_id) AS total_candidates, 
        jobs.job_name, jobs.job_description, jobs.remuneration_data, 
        jobs.delivery_time, contract.designer_id 
        FROM {$this->tableName} LEFT JOIN contract ON (contract.job_id = jobs.id)";

        if (!empty($terms)) {
            $sql .= " WHERE {$terms} GROUP BY jobs.id";
        } else {
            $sql .= " GROUP BY jobs.id";
        }

        if (!empty($limitValue)) {
            $sql .= " LIMIT {$limitValue}";
        }

        $stmt = $this->read($sql, $params);

        if (empty($stmt)) {
            return;
        }

        if (empty($stmt->rowCount())) {
            return;
        }

        $jobsData = $stmt->fetchAll(\PDO::FETCH_OBJ);
        return $jobsData;
    }

    public function getJobsWithCandidates(int $id = 0, int $limitValue = 0, int $offsetValue = 0, bool $orderBy = false, bool $hashId = false)
    {
        $param = "";
        $sql = "SELECT jobs.id, COUNT(contract.designer_id) AS total_candidates,
        jobs.job_name, jobs.job_description,
        jobs.remuneration_data, jobs.delivery_time, contract.designer_id
        FROM {$this->tableName} LEFT JOIN contract ON (contract.job_id = jobs.id)";

        if (!empty($id)) {
            $sql .= " WHERE jobs.business_man_id = :business_man_id GROUP BY jobs.id";
            $param .= "business_man_id=" . $id . "";
        } else {
            $sql .= " GROUP BY jobs.id";
        }

        if ($orderBy) {
            $sql .= " ORDER BY jobs.id DESC";
        }

        if (!empty($limitValue)) {
            $sql .= " LIMIT {$limitValue}";
        }

        if (!empty($offsetValue)) {
            $sql .= " OFFSET {$offsetValue}";
        }

        $stmt = $this->read($sql, $param);

        if (empty($stmt)) {
            return;
        }

        if (empty($stmt->rowCount())) {
            return;
        }

        $jobsData = $stmt->fetchAll(\PDO::FETCH_OBJ);

        if ($hashId) {
            if (!empty($jobsData)) {
                foreach ($jobsData as &$job) {
                    $job->id = base64_encode($job->id);
                }
            }
        }


        return $jobsData;
    }
}
