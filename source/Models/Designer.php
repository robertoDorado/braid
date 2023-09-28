<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Designer Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Designer extends Model
{
    private string $tableName = CONF_DB_NAME . ".designer";

    private string $fullName = 'full_name';

    private string $fullEmail = 'full_email';

    private string $documentData = 'document_data';

    private string $biographyData = 'biography_data';

    private string $goalsData = 'goals_data';

    private string $qualificationsData = 'qualifications_data';

    private string $portfolioData = 'portfolio_data';

    private string $experienceData = 'experience_data';

    /**
     * Designer constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->fullName, $this->fullEmail]);
    }
}
