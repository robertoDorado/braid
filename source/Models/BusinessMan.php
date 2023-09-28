<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * BusinessMan Source\Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class BusinessMan extends Model
{
    private string $tableName = CONF_DB_NAME . ".business_man";

    /** @var string Nome do contratante */
    private string $fullName = 'full_name';

    /** @var string Email do contratante */
    private string $fullEmail = 'full_email';

    /** @var string  Nome da empresa */
    private string $companyName = 'company_name';

    /** @var string Numero do CPNJ da empresa */
    private string $registerNumber = 'register_number';

    /** @var string Descrição sobre a empresa */
    private string $companyDescription = 'company_description';

    /** @var string Descrição sobre o ramo da empresa */
    private string $branchOfCompany = 'branch_of_company';

    /** @var bool Verificação se a empresa é valida */
    private string $validCompany = 'valid_company';

    /**
     * BusinessMan constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ['id'], [$this->fullName, $this->fullEmail]);
    }
}
