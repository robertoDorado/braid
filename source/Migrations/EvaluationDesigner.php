<?php
namespace Source\Migrations;

require __DIR__ . "../../../vendor/autoload.php";

use Source\Migrations\Core\DDL;
use Source\Models\EvaluationDesigner as ModelsEvaluationDesigner;

/**
 * EvaluationDesigner Migrations
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Migrations
 */
class EvaluationDesigner extends DDL
{
    /**
     * EvaluationDesigner constructor
     */
    public function __construct()
    {
        parent::__construct(ModelsEvaluationDesigner::class);
    }

    public function defineTable()
    {
        $this->setClassProperties();
        $this->removeProperty('table_name');
        $this->setProperty('');
        $this->setProperty('');
        $this->setKeysToProperties(['BIGINT AUTO_INCREMENT PRIMARY KEY', 'BIGINT NOT NULL',
        'BIGINT NOT NULL', 'BIGINT NOT NULL', 'VARCHAR(255) NOT NULL', 
        'CONSTRAINT `evaluation_designer_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `designer` (`id`)',
        'CONSTRAINT `evaluation_business_man_ibfk_1` FOREIGN KEY (`business_man_id`) REFERENCES `business_man` (`id`)']);
        $this->dropTableIfExists()->createTableQuery();
        $this->executeQuery();
    }
}

(new EvaluationDesigner())->defineTable();