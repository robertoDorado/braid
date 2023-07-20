<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Designer Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Designer extends Model
{
    private string $tableName = CONF_DB_NAME . ".designer";

    /**
     * Designer constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], ['name', 'biography', 'goals', 'qualifications', 'experience']);
    }
}
