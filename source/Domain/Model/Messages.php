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

    /** @var bool Atributo para saber se a mensagem foi lida */
    private bool $isRead;

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
            $this->messages->is_read = !$this->isRead() ? 0 : 1;
            if (!$this->messages->save()) {
                if (!empty($this->messages->fail())) {
                    throw new \PDOException($this->messages->fail()->getMessage() . " " . $this->messages->queryExecuted());
                }else {
                    throw new \PDOException($this->messages->message());
                }
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function updateIsReadByUser(User $senderUser, User $receiverUser)
    {
        $this->messages = new ModelsMessages();
        $messages = $this->messages->find("receiver_id=:receiver_id AND sender_id=:sender_id",
            ":receiver_id=" . $receiverUser->getId() . "&:sender_id=" . $senderUser->getId() . "")->fetch(true);
        
        if (empty($messages)) {
            throw new \Exception("mensagens do usuário não existe");
        }

        foreach ($messages as $message) {
            $message->is_read = 1;
            if (!$message->save()) {
                if (!empty($message->fail())) {
                    throw new \PDOException($message->fail()->getMessage() . " " . $message->queryExecuted());
                }else {
                    throw new \PDOException($message->message());
                }
            }
        }
    }

    public function setRead(bool $isRead)
    {
        $this->isRead = $isRead;
    }

    public function isRead()
    {
        return $this->isRead;
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
