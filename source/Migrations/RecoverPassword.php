<?php
namespace Source\Migrations;

use Source\Migrations\Core\DDL;
use Source\Models\RecoverPassword as ModelsRecoverPassword;

require __DIR__ . "../../../vendor/autoload.php";

/**
 * RecoverPassword Source\Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class RecoverPassword extends DDL
{
    /**
     * RecoverPassword constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsRecoverPassword::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'BIGINT(20) NOT NULL',
        'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'VARCHAR(255) NOT NULL', 'TINYINT(1) NOT NULL',
        'DATETIME NOT NULL', 'KEY id_user (id_user)',
        'CONSTRAINT FK1_user FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE NO ACTION ON UPDATE NO ACTION']);
        $this->dropTableIfExists()->createTableQuery();
        $this->executeQuery();
    }
}
(new RecoverPassword())->defineTable();