<?php
namespace Source\Migrations;

require __DIR__ . "../../../vendor/autoload.php";

use Source\Migrations\Core\DDL;
use Source\Models\Messages as ModelsMessages;

/**
 * Messages Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Messages extends DDL
{
    /**
     * Messages constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsMessages::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty("table_name");
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(["BIGINT AUTO_INCREMENT PRIMARY KEY",
        "BIGINT NOT NULL", "BIGINT NOT NULL", "VARCHAR(1000) NOT NULL", "DATETIME NOT NULL", "TINYINT NOT NULL",
        "CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)",
        "CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`)"]);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }
}

(new Messages())->defineTable();