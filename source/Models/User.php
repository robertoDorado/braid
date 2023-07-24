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

    /** @var string Nome do usuario */
    private string $name = 'name';

    /** @var string Login do usuario */
    private string $login = 'login';

    /** @var string Email do usuario */
    private string $email = 'email';

    /** @var string Senha do usuario */
    private string $password = 'password';

    /** @var string Cpf do usuario */
    private string $document = 'document';

    /** @var string Tipo de usuario */
    private string $userType = 'user_type';

    /** @var string Foto do usuario */
    private string $pathPhoto = 'path_photo';

    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->name, $this->login, $this->email, $this->password, $this->document, $this->userType, $this->pathPhoto]);
    }
}
