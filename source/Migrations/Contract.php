<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\Contract as ModelsContract;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * Contract Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Contract extends DDL
{
    /**
     * Contract constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsContract::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'BIGINT NOT NULL', 'BIGINT NOT NULL',
        'VARCHAR(1000) NOT NULL', 'TINYINT(1) NULL', 'TINYINT(1) NULL',
        'CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `designer` (`id`)',
        'CONSTRAINT `contract_ibfk_3` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`)']);
        $this->setForeignKeyChecks(0)->dropTableIfExists()->createTableQuery()->setForeignKeyChecks(1);
        $this->executeQuery();
    }

    public function addColumnToContractTable()
    {
        $this->alterTable(["ADD COLUMN job_id BIGINT NOT NULL", " ADD CONSTRAINT contract_ibfk_3 FOREIGN KEY (job_id) REFERENCES jobs(id)"]);
        $this->executeQuery();
    }

    public function removeColumnBusinessManId()
    {
        $this->alterTable(["DROP FOREIGN KEY contract_ibfk_2", "DROP COLUMN business_man_id"]);
        $this->executeQuery();
    }
}

(new Contract())->defineTable();