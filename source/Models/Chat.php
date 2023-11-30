<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Chat Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Chat extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".chat";

    /** @var string Id da empresa */
    private string $businessManId = 'business_man_id';

    /** @var string Id do freelancer */
    private string $designerId = 'designer_id';

    /** @var string Mensagem */
    private string $chatMessage = 'chat_message';

    /**
     * Chat constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ["id"], [$this->businessManId, $this->designerId, $this->chatMessage]);
    }
}
