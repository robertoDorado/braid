<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Messages Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Messages extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".messages";

    /** @var string Id do usuário que envia a mensagem */
    private string $senderId = 'sender_id';

    /** @var string Id do usuário que recebe a mensagem */
    private string $receiverId = 'receiver_id';

    /** @var string conteúdo da mensagem */
    private string $content = 'content';

    /** Data e hora da mensagem */
    private string $dateTime = 'date_time';

    /**
     * Messages constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ["id"], [$this->senderId, $this->receiverId, $this->content, $this->dateTime]);
    }
}
