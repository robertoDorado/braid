<?php
namespace Source\Domain\Tests;

use PDOException;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\Contact;
use Source\Domain\Model\Conversation;
use Source\Domain\Model\User;

/**
 * ContactTest Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class ContactTest extends TestCase
{
    /** @var Contact Objeto de persistência */
    private Contact $contact;

    public function testGetContactsByUser()
    {
        $this->contact = new Contact();
        $user = new User();
        $contactsData = $this->contact->getContactsUserByIdUser($user);
        $this->assertIsArray($contactsData);
    }

    public function testGetConversation()
    {
        $this->contact = new Contact();
        $conversation = new Conversation();
        $this->contact->setConversation($conversation);
        $conversation = $this->contact->getConversation();
        $this->assertInstanceOf(Conversation::class, $conversation);
    }

    public function testGetUser()
    {
        $this->contact = new Contact();
        $user = new User();
        $this->contact->setUser($user);
        $user = $this->contact->getUser();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testSetModelContact()
    {
        $this->contact = new Contact();
        $user = new User();
        $conversation = new Conversation();
        $this->contact->setUser($user);
        $this->contact->setConversation($conversation);
        $this->expectException(PDOException::class);
        $this->contact->setModelContact($this->contact);
    }
}
