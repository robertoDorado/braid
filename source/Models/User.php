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

    /** @var string userName do usuario */
    private string $user_name = 'user_name';

    /** @var string Email do usuario */
    private string $email = 'email';

    /** @var string Senha do usuario */
    private string $password = 'password';

    /** @var string Tipo de usuario */
    private string $userType = 'user_type';

    /** @var string Foto do usuario */
    private string $pathPhoto = 'path_photo';

    /** @var string Verifica se o usuário é válido */
    private string $isValidUser = 'is_valid_user';

    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->name, $this->user_name, $this->email, $this->password, $this->userType, $this->pathPhoto, $this->isValidUser]);
    }
}
