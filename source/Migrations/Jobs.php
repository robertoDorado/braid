<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\Jobs as ModelsJobs;

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
        parent::__construct(ModelsJobs::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'BIGINT NOT NULL',
        'VARCHAR(255) NOT NULL', 
        'VARCHAR(1000) NOT NULL', 'DECIMAL(10, 2) NOT NULL',
        'DATETIME NOT NULL',
        'FOREIGN KEY (business_man_id) REFERENCES business_man(id)']);
        $this->dropTableIfExists()->createTableQuery();
        $this->executeQuery();
    }

    public function modifyColumnJobs()
    {
        $this->alterTable(["MODIFY COLUMN job_description VARCHAR(1000)"]);
        $this->executeQuery();
    }
}

(new Jobs())->modifyColumnJobs();