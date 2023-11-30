<?php
namespace Source\Domain\Model;

use Source\Models\Chat as ModelsChat;

/**
 * Chat Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Chat
{
    /** @var BusinessMan Objeto BusinessMan */
    private BusinessMan $businessMan;

    /** @var Designer Objeto Designer */
    private Designer $designer;

    /** @var string Mesnagem do chat */
    private string $chatMessage;

    /** @var ModelsChat Objeto de persistência */
    private ModelsChat $chat;

    public function setModelChatMessage(Chat $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->chat = new ModelsChat();
            $this->chat->business_man_id = $this->getBusinessMan()->getId();
            $this->chat->designer_id = $this->getDesigner()->getId();
            $this->chat->chat_message = $this->getChatMessage();
            if (!$this->chat->save()) {
                throw new \Exception($this->chat->fail());
            }
        }
    }

    public function getChatMessage()
    {
        return $this->chatMessage;
    }

    public function setChatMessage(string $message)
    {
        if (strlen($message) > 1000) {
            throw new \Exception("Campo mensagem ultrapassa o limite de caracteres");
        }

        $this->chatMessage = $message;
    }

    public function getDesigner()
    {
        return $this->designer;
    }

    public function setDesigner(Designer $designer)
    {
        $this->designer = $designer;
    }

    public function getBusinessMan()
    {
        return $this->businessMan;
    }

    public function setBusinessMan(BusinessMan $businessMan)
    {
        $this->businessMan = $businessMan;
    }
}
