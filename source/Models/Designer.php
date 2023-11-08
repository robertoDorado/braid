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

    /** @var string Nome Completo */
    private string $fullName = 'full_name';

    /** @var string E-mail completo */
    private string $fullEmail = 'full_email';

    /** @var string Foto de identificação */
    private string $photoPath = 'photo_path';

    /** @var string documento de identificação */
    private string $documentData = 'document_data';

    /** @var string Biografia (curriculo) */
    private string $biographyData = 'biography_data';

    /** @var string Objetivos e métas (curriculo) */
    private string $goalsData = 'goals_data';

    /** @var string Qualificações profissionais (curriculo) */
    private string $qualificationsData = 'qualifications_data';

    /** @var string Portfólio (curriculo) */
    private string $portfolioData = 'portfolio_data';

    /** @var string Experiência profissional (curriculo) */
    private string $experienceData = 'experience_data';

    /**
     * Designer constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->fullName, $this->fullEmail]);
    }
}
