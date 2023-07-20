<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Contract Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Contract extends Model
{
    private string $tableName = CONF_DB_NAME . ".contract";

    /**
     * Contract constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], ['designer_id', 'businessman_id', 'jobs', 'jobs_description', 'timestamp_jobs', 'remuneration', 'signature_businessman', 'signature_designer']);    
    }
}
