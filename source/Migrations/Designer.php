<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\Designer as ModelsDesigner;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * Designer Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Designer extends DDL
{
    /**
     * Designer constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsDesigner::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL UNIQUE',
        'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(255) NULL',
        'VARCHAR(255) NULL', 'VARCHAR(255) NULL']);
        $this->createTableQuery();
        $this->executeQuery();
    }

    public function setEmailColumn()
    {
        $this->setClassProperties();
        $this->alterTable(['ADD email VARCHAR(255) NOT NULL', 'ADD CONSTRAINT email UNIQUE (email)']);
        $this->executeQuery();
    }
}

print_r((new Designer())->defineTable());