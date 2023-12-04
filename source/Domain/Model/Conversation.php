<?php
namespace Source\Domain\Model;

use PDOException;
use Source\Models\Conversation as ModelsConversation;

/**
 * Coversation Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Conversation
{
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
                }else {
                    throw new PDOException($this->conversation->message());
                }
            }
        }
    }

    public function getConversationAndMessages(array $users)
    {
        $this->conversation = new ModelsConversation();
        $conversationData = $this->conversation
        ->find("", "id_user IN(" . implode(",", $users). ")")
        ->advancedJoin("messages", "conversation.id_message = messages.id", "", "", "sender_id, receiver_id, content, date_time")
        ->advancedJoin("user", "conversation.id_user = user.id", "", "", "full_name, path_photo")->fetch(true);

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
