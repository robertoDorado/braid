<?php
namespace Source\Migrations;

use Source\Domain\Model\Contract as DomainModelContract;
use Source\Migrations\Core\DDL;

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
        parent::__construct(DomainModelContract::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->changeValueOfProperties(11, 'business_man_id');
        $this->changeValueOfProperties(12, 'designer_id');
        $this->removeProperty('contract');
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(['INT AUTO_INCREMENT PRIMARY KEY', 
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'TIMESTAMP NOT NULL DEFAULT current_timestamp()',
        'DECIMAL(10,2) NOT NULL', 'VARCHAR(255) DEFAULT NULL', 'VARCHAR(255) DEFAULT NULL', 'DATE DEFAULT NULL',
        'VARCHAR(255) DEFAULT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'INT NOT NULL', 'INT NOT NULL',
        'CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `designer` (`id`) ON DELETE CASCADE',
        'CONSTRAINT `contract_ibfk_2` FOREIGN KEY (`business_man_id`) REFERENCES `business_man` (`id`) ON DELETE CASCADE']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new Contract())->defineTable();