<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Contract Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Contract extends Model
{
    private string $tableName = CONF_DB_NAME . ".contract";

    /** @var string Designer id chave estrangeira */
    private string $designerId = 'designer_id';

    /** @var string Jobs id chave estrangeira */
    private string $jobId = 'job_id';

    /** @var string Descrições adicionais sobre o trabalho que será feito */
    private string $additionalDescription = 'additional_description';

    /** @var string Assinatura do contratante */
    private string $signatureBusinessMan = 'signature_business_man';

    /** @var string Assinatura do contratado */
    private string $signatureDesigner = 'signature_designer';

    /**
     * Contract constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->designerId, $this->jobId, $this->additionalDescription, $this->signatureBusinessMan, $this->signatureDesigner]);    
    }
}
