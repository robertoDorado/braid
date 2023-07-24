<?php
namespace Source\Migrations;

use Source\Domain\Model\Designer as DomainModelDesigner;
use Source\Migrations\Core\DDL;

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
        parent::__construct(DomainModelDesigner::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('contracts');
        $this->removeProperty('designer');
        $this->setKeysToProperties(['INT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new Designer())->defineTable();