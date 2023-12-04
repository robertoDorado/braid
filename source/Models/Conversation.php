<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Conversation Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Conversation extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".conversation";

    /** @var string Id do usuário logado */
    private string $idUser = "id_user";

    /** @var string Id da mensagem */
    private string $idMessage = "id_message";

    /**
     * Conversation constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ["id"], [$this->idUser, $this->idMessage]);
    }
}
