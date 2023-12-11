<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\Credentials as ModelsCredentials;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * Credentials Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Credentials extends DDL
{
    /**
     * Credentials constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsCredentials::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY',
        'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(255) NULL']);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }
}

(new Credentials())->defineTable();