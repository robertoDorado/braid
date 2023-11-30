<?php
namespace Source\Migrations;

require_once __DIR__ . "../../../vendor/autoload.php";

use Source\Migrations\Core\DDL;
use Source\Models\Chat as ModelsChat;

/**
 * Chat Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Chat extends DDL
{
    /**
     * Chat constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsChat::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty("table_name");
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(["BIGINT AUTO_INCREMENT PRIMARY KEY",
        "BIGINT NOT NULL", "BIGINT NOT NULL", "VARCHAR(1000) NOT NULL",
        "CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `designer` (`id`)",
        "CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`business_man_id`) REFERENCES `business_man` (`id`)"]);
        $this->dropTableIfExists()->createTableQuery();
        $this->executeQuery();
    }
}

(new Chat())->defineTable();