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

    public function getJobsWithCandidates(int $id = 0, int $limitValue = 0, int $offsetValue = 0, bool $orderBy = false, bool $hashId = false)
    {
        $param = "";
        $sql = "SELECT 
        braid.jobs.id, COUNT(contract.designer_id) AS total_candidates,
        braid.jobs.job_name, braid.jobs.job_description,
        braid.jobs.remuneration_data, braid.jobs.delivery_time, contract.designer_id
        FROM jobs
        LEFT JOIN contract ON (contract.job_id = jobs.id)";

        if (!empty($id)) {
            $sql .= " WHERE jobs.business_man_id = :business_man_id GROUP BY jobs.id";
            $param .= "business_man_id=" . $id . "";
        }else {
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

        if ($stmt->rowCount() == 0) {
            return null;
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
