<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * RecoverPassword Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class RecoverPassword extends Model
{
    /** @var string Nome da tabela */
    private $tableName = CONF_DB_NAME . ".recover_password";

    /**
     * RecoverPassword constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], ['id_user', 'user', 'email', 'hash', 'is_valid']);
    }
}
