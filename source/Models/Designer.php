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

    private string $name = 'name';

    private string $document = 'document';

    private string $biography = 'biography';

    private string $goals = 'goals';

    private string $qualifications = 'qualifications';

    private string $portfolio = 'portfolio';

    private string $experience = 'experience';

    /**
     * Designer constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->name, $this->document, $this->biography, $this->goals, $this->qualifications, $this->experience, $this->portfolio]);
    }
}
