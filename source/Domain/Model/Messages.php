<?php

namespace Source\Domain\Model;

use Source\Core\Connect;
use Source\Models\Messages as ModelsMessages;

/**
 * Messages Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Messages
{
    /** @var int Id chave primária */
    private int $id = 0;

    /** @var User Id do usuário que envia a mensagem */
    private User $senderUser;

    /** @var User Id do usuário que recebe a mensagem */
    private User $receiverUser;

    /** @var string Conteúdo da mensagem */
    private string $content;

    /** @var string Data e Hora da conversa */
    private string $dateTime;

    /** @var ModelsMessages Objeto de persistência */
    private ModelsMessages $messages;

    public function setModelMessage(Messages $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->messages = new ModelsMessages();
            $this->messages->sender_id = $this->getSenderUser()->getId();
            $this->messages->receiver_id = $this->getReceiverUser()->getId();
            $this->messages->content = $this->getContent();
            $this->messages->date_time = $this->getDateTime();
            if (!$this->messages->save()) {
                if (!empty($this->messages->fail())) {
                    throw new \PDOException($this->messages->fail()->getMessage());
                }else {
                    throw new \PDOException($this->messages->message());
                }
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setDateTime(string $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getReceiverUser()
    {
        return $this->receiverUser;
    }

    public function setReceiverUser(User $receiverUser)
    {
        $this->receiverUser = $receiverUser;
    }

    public function getSenderUser()
    {
        return $this->senderUser;
    }

    public function setSenderUser(User $senderUser)
    {
        $this->senderUser = $senderUser;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
