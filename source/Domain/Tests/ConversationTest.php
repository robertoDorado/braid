<?php
namespace Source\Domain\Tests;

use PDOException;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\Conversation;
use Source\Domain\Model\Messages;
use Source\Domain\Model\User;

/**
 * CoversationTest Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class ConversationTest extends TestCase
{
    private Conversation $conversation;

    public function testGetUser()
    {
        $this->conversation = new Conversation();
        $user = new User();
        $this->conversation->setUser($user);
        $user = $this->conversation->getUser();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testGetMessages()
    {
        $this->conversation = new Conversation();
        $message = new Messages();
        $this->conversation->setMessage($message);
        $message = $this->conversation->getMessage();
        $this->assertInstanceOf(Messages::class, $message);
    }

    public function testGetConversationAndMessages()
    {
        $this->conversation = new Conversation();
        $userReceiver = new User();
        $userReceiver->setId(0);
        $userSender = new User();
        $userSender->setId(0);
        $conversationData = $this->conversation
            ->getConversationAndMessages([$userReceiver->getId(), $userSender->getId()]);
        $this->assertIsArray($conversationData);
    }

    public function testGetId()
    {
        $this->conversation = new Conversation();
        $this->conversation->setId(0);
        $id = $this->conversation->getId();
        $this->assertIsInt($id);
    }

    public function testSetModelConversation()
    {
        $this->conversation = new Conversation();
        $this->conversation->setUser(new User());
        $this->conversation->setMessage(new Messages());
        $this->expectException(PDOException::class);
        $this->conversation->setModelConversation($this->conversation);
    }
}
