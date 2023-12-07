<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Contact Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Contact extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".contact";

    /** @var string Id do usuário logado */
    private string $idUser = "id_user";

    /** @var string Id do contato */
    private string $idConversation = "id_conversation";

    /**
     * Contact constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ["id"], [$this->idUser, $this->idConversation]);
    }
}
