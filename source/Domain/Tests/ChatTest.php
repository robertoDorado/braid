<?php
namespace Source\Domain\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Chat;
use Source\Domain\Model\Designer;

/**
 * ChatTest Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class ChatTest extends TestCase
{
    /** @var Chat Objeto */
    private Chat $chat;

    public function testGetBusinessMan()
    {
        $this->chat = new Chat();
        $this->chat->setBusinessMan(new BusinessMan());

        $businessMan = $this->chat->getBusinessMan();
        $this->assertInstanceOf(BusinessMan::class, $businessMan);
    }

    public function testGetDesigner()
    {
        $this->chat = new Chat();
        $this->chat->setDesigner(new Designer());

        $designer = $this->chat->getDesigner();
        $this->assertInstanceOf(Designer::class, $designer);
    }

    public function testExceptionChatMessage()
    {
        $this->chat = new Chat();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Campo mensagem ultrapassa o limite de caracteres");
        $this->chat->setChatMessage("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960 stypesetting, remaining essentially unchanged.");
    }

    public function testGetChatMessage()
    {
        $this->chat = new Chat();
        $this->chat->setChatMessage("teste nova mensagem");
        $message = $this->chat->getChatMessage();
        $this->assertIsString($message);
    }
}