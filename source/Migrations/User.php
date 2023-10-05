<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\User as ModelsUser;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * User Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class User extends DDL
{
    /**
     * User constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsUser::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NULL', 'TINYINT(1) NOT NULL',
        'UNIQUE KEY full_email (full_email)', 'UNIQUE KEY nick_name (nick_name)']);
        $this->dropTableIfExists()->createTableQuery();
        $this->executeQuery();
    }
}

(new User())->defineTable();