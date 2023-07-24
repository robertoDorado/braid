<?php
namespace Source\Migrations;

use Source\Domain\Model\User as DomainModelUser;
use Source\Migrations\Core\DDL;

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
        parent::__construct(DomainModelUser::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('user');
        $this->setProperty('name');
        $this->setProperty('document');
        $this->setProperty('path_photo');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'UNIQUE KEY email (email)']);
        $this->createTableQuery();
        $this->executeQuery();
    }
}

(new User())->defineTable();