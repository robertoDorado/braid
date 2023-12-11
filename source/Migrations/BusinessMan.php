<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\BusinessMan as ModelsBusinessMan;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * BusinessMan Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class BusinessMan extends DDL
{
    /**
     * BusinessMan constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsBusinessMan::class);   
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL UNIQUE',
        'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(1000) NULL', 'VARCHAR(255) NULL', 
        'TINYINT(1) NULL']);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }

    public function setEmailColumn()
    {
        $this->alterTable(['ADD full_email VARCHAR(255) NOT NULL', 'ADD CONSTRAINT full_email UNIQUE (full_email)']);
        $this->executeQuery();
    }

    public function setOneThousendVarcharCompanyDescription()
    {
        $this->alterTable(["MODIFY company_description VARCHAR(1000) NULL"]);
        $this->executeQuery();
    }

    public function setColumnPathPhoto()
    {
        $this->alterTable(["ADD COLUMN path_photo VARCHAR(255)"]);
        $this->executeQuery();
    }
}

(new BusinessMan())->defineTable();