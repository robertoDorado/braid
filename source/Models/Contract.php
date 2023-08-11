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

    /** @var string BusinessMan id chave estrangeira */
    private string $businessManId = 'business_man_id';

    /** @var string Trabalhos a serem realizados */
    private string $jobs = 'jobs';

    /** @var string Descrição dos trabalhos a serem realizados */
    private string $jobsDescription = 'jobs_description';

    /** @var string Data e hora para termino do contrato */
    private string $timestampJobs = 'timestamp_jobs';

    /** @var string Valor do acordo entre o contratante e o contratado */
    private string $remuneration = 'remuneration';

    /** @var string Clausula para propriedade intelectual */
    private string $intellectualProperty = 'intellectual_property';

    /** @var string Clausula para confidencialidade */
    private string $confidentiality = 'confidentiality';

    /** @var string Data de recisão do contrato */
    private string $terminationOfContract = 'termination_of_contract';
    
    /** @var string Clausulas adicionais */
    private string $additionalClauses = 'additional_clauses';

    /** @var string Assinatura do contratante */
    private string $signatureBusinessMan = 'signature_business_man';

    /** @var string Assinatura do contratado */
    private string $signatureDesigner = 'signature_designer';

    /**
     * Contract constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->designerId, $this->businessManId, $this->jobs, $this->jobsDescription, $this->timestampJobs, $this->remuneration, $this->intellectualProperty, $this->confidentiality, $this->terminationOfContract, $this->additionalClauses, $this->signatureBusinessMan, $this->signatureDesigner]);    
    }
}
