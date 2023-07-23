<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * BusinessMan Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class BusinessMan extends Model
{
    private string $tableName = CONF_DB_NAME . ".businessman";
    /**
     * BusinessMan constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], ['name', 'company_name', 'register_number', 'company_description', 'branch_of_company', 'job_description', 'valid_company']);
    }
}
