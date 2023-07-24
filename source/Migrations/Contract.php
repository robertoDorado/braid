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
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'DATETIME NOT NULL',
        'DECIMAL(10,2) NOT NULL', 'VARCHAR(255) DEFAULT NULL', 'VARCHAR(255) DEFAULT NULL', 'DATE DEFAULT NULL',
        'VARCHAR(255) DEFAULT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL',
        'CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `designer` (`id`)',
        'CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`business_man_id`) REFERENCES `business_man` (`id`)']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new Contract())->defineTable();