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
    private string $fullName = 'full_name';

    /** @var string userName do usuario */
    private string $nickName = 'nick_name';

    /** @var string Email do usuario */
    private string $fullEmail = 'full_email';

    /** @var string Senha do usuario */
    private string $passwordData = 'password_data';

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
        parent::__construct($this->tableName, ['id'], [$this->fullName, $this->nickName, $this->fullEmail, $this->passwordData, $this->userType, $this->pathPhoto, $this->isValidUser]);
    }
}
