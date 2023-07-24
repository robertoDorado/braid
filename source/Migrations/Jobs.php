<?php
namespace Source\Migrations;

use Source\Domain\Model\Jobs as DomainModelJobs;
use Source\Migrations\Core\DDL;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * Jobs Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class Jobs extends DDL
{
    /**
     * Jobs constructor
     */
    public function __construct()
    {
        parent::__construct(DomainModelJobs::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->setProperty('');
        $this->changeValueOfProperties(5, 'businessman_id');
        $this->setKeysToProperties(['INT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL', 
        'VARCHAR(255) NOT NULL', 'DECIMAL(10, 2) NOT NULL',
        'DATETIME NOT NULL', 'INT NOT NULL',
        'FOREIGN KEY (businessman_id) REFERENCES business_man(id)']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new Jobs())->defineTable();