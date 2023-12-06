<?php

namespace Source\Domain\Model;

use PDOException;
use Source\Core\Connect;
use Source\Models\Conversation as ModelsConversation;

/**
 * Coversation Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Conversation
{
    /** @var int Id da conversa */
    private int $id = 0;

    /** @var User Id do usuário que possui a conversa atual */
    private User $user;

    /** @var Message Id da mensagem */
    private Messages $message;

    /** @var ModelsConversation Objeto de persistência */
    private ModelsConversation $conversation;

    public function setModelConversation(Conversation $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->conversation = new ModelsConversation();
            $this->conversation->id_user = $this->getUser()->getId();
            $this->conversation->id_message = $this->getMessage()->getId();
            if (!$this->conversation->save()) {
                if (!empty($this->conversation->fail())) {
                    throw new PDOException($this->conversation->fail()->getMessage());
                } else {
                    throw new PDOException($this->conversation->message());
                }
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getConversationAndMessages(array $users)
    {
        $this->conversation = new ModelsConversation();
        $conversationData = $this->conversation
            ->find("")
            ->advancedJoin(
                "messages",
                "conversation.id_message = messages.id",
                "",
                "",
                "sender_id, receiver_id, content, date_time"
            )
            ->in("braid.messages.sender_id IN(" . implode(",", $users) . ") AND braid.messages.receiver_id IN(" . implode(",", $users) . ")")
            ->advancedJoin("user", "conversation.id_user = user.id", "", "", "full_name, path_photo")
            ->fetch(true);

        if (!empty($conversationData)) {
            foreach ($conversationData as &$conversation) {
                $conversation->date_time = date("d/m/Y H:i", strtotime($conversation->date_time));
                $conversation->full_name = empty($conversation->full_name) ? "" : $conversation->full_name;
                $conversation->full_name = explode(" ", $conversation->full_name);
                $conversation->full_name = $conversation->full_name[0];
            }
        }

        return $conversationData;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage(Messages $message)
    {
        $this->message = $message;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}
