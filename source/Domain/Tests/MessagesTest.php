<?php

namespace Source\Domain\Tests;

use Exception;
use PDOException;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\Messages;
use Source\Domain\Model\User;

/**
 * MessagesTest Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class MessagesTest extends TestCase
{
    private Messages $messages;

    public function testGetId()
    {
        $this->messages = new Messages();
        $this->messages->setId(0);
        $id = $this->messages->getId();
        $this->assertIsInt($id);
    }

    public function testGetSender()
    {
        $this->messages = new Messages();
        $sender = new User();
        $this->messages->setSenderUser($sender);
        $sender = $this->messages->getSenderUser();
        $this->assertInstanceOf(User::class, $sender);
    }

    public function testGetReceiver()
    {
        $this->messages = new Messages();
        $receiver = new User();
        $this->messages->setReceiverUser($receiver);
        $receiver = $this->messages->getReceiverUser();
        $this->assertInstanceOf(User::class, $receiver);
    }

    public function testGetContent()
    {
        $this->messages = new Messages();
        $this->messages->setContent("New Message...");
        $message = $this->messages->getContent();
        $this->assertIsString($message);
    }

    public function testGetDateTime()
    {
        $this->messages = new Messages();
        $this->messages->setDateTime(date("Y-m-d H:i"));
        $dateTime = $this->messages->getDateTime();
        $this->assertIsString($dateTime);
    }

    public function testIsRead()
    {
        $this->messages = new Messages();
        $this->messages->setRead(true);
        $isRead = $this->messages->isRead();
        $this->assertIsBool($isRead);
    }

    public function testUpdateIsReadByUser()
    {
        $this->messages = new Messages();
        $sender = new User();
        $sender->setId(0);
        $receiver = new User();
        $receiver->setId(0);
        $this->expectException(Exception::class);
        $this->messages->updateIsReadByUser($sender, $receiver);
    }

    public function testSetModelMessage()
    {
        $this->messages = new Messages();
        $sender = new User();
        $sender->setId(0);
        $receiver = new User();
        $receiver->setId(0);
        $this->messages->setContent("");
        $this->messages->setDateTime("");
        $this->messages->setRead(false);
        $this->messages->setSenderUser($sender);
        $this->messages->setReceiverUser($receiver);
        $this->expectException(PDOException::class);
        $this->messages->setModelMessage($this->messages);
    }
}
