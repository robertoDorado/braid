<?php
namespace Source\Migrations;

require __DIR__ . "../../../vendor/autoload.php";

use Source\Migrations\Core\DDL;
use Source\Models\Conversation as ModelsConversation;

/**
 * Conversation Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Conversation extends DDL
{
    /**
     * Conversation constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsConversation::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty("table_name");
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(["BIGINT AUTO_INCREMENT PRIMARY KEY",
        "BIGINT NOT NULL", "BIGINT NOT NULL",
        "CONSTRAINT `conversation_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)",
        "CONSTRAINT `conversation_ibfk_2` FOREIGN KEY (`id_message`) REFERENCES `messages` (`id`)"]);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }
}

(new Conversation())->defineTable();