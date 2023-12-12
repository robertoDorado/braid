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
        'VARCHAR(255) NULL', 'VARCHAR(255) NULL', 'VARCHAR(1000) NULL', 'VARCHAR(1000) NULL', 'VARCHAR(1000) NULL',
        'VARCHAR(1000) NULL', 'VARCHAR(1000) NULL', 'VARCHAR(1000) NULL']);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }

    public function setEmailColumn()
    {
        $this->alterTable(['ADD email VARCHAR(255) NOT NULL', 'ADD CONSTRAINT email UNIQUE (email)']);
        $this->executeQuery();
    }

    public function setColumnPathPhoto()
    {
        $this->alterTable(["ADD path_photo VARCHAR(255) NULL"]);
        $this->executeQuery();
    }

    public function setColumnOneThousendLengthVarchar()
    {
        $this->alterTable(["MODIFY biography_data VARCHAR(1000)",
        "MODIFY goals_data VARCHAR(1000)", "MODIFY qualifications_data VARCHAR(1000)",
        "MODIFY portfolio_data VARCHAR(1000)", "MODIFY experience_data VARCHAR(1000)"]);
        $this->executeQuery();
    }

    public function setColumnPositionData()
    {
        $this->alterTable(["ADD position_data VARCHAR(255) NULL"]);
        $this->executeQuery();
    }
}

(new Designer())->defineTable();