<?php
namespace Source\Models;

use ReflectionClass;
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
    private string $tableName = CONF_DB_NAME . ".recover_password";

    private string $idUser = 'id_user';

    private string $nickName = 'nick_name';

    private string $fullEmail = 'full_email';

    private string $hashData = 'hash_data';

    private string $isValid = 'is_valid';

    private string $expiresIn = 'expires_in';

    /**
     * RecoverPassword constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->idUser, $this->nickName, $this->fullEmail, $this->hashData, $this->isValid, $this->expiresIn]);
    }
}
