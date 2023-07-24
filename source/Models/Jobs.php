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
    private string $remuneration = 'remuneration';

    /** @var string Tempo máximo para entrega */
    private string $deliveryTime = 'delivery_time';
    /**
     * Jobs constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->businessManId, $this->jobName, $this->jobDescription, $this->jobDescription, $this->remuneration, $this->deliveryTime]);
    }
}
