<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * User Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class User extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".user";

    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], ['name', 'document', 'email', 'path_photo', 'login', 'password', 'user_type']);
    }
}
