<?php
namespace Source\Migrations;

use Source\Domain\Model\BusinessMan as DomainModelBusinessMan;
use Source\Migrations\Core\DDL;

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
        parent::__construct(DomainModelBusinessMan::class);   
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('contracts');
        $this->removeProperty('business_man');
        $this->setKeysToProperties(['INT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 
        'TINYINT(1) NOT NULL']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new BusinessMan())->defineTable();