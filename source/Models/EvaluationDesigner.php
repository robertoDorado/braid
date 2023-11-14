<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * EvaluationDesigner Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class EvaluationDesigner extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".evaluation_designer";

    /** @var string Id designer */
    private string $designerId = 'designer_id';

    /** @var string Coluna avaliação */
    private string $ratingData = 'rating';

    /** @var string Descrição sobre a avaliação */
    private string $evaluationDescription = 'evaluation_description';

    /**
     * EvaluationDesigner constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->designerId, $this->ratingData, $this->evaluationDescription]);
    }
}
