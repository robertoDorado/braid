<?php
namespace Source\Models;

use Source\Core\Model;

/**
 * Credentials Models
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Models
 */
class Credentials extends Model
{
    /** @var string Nome da tabela */
    private string $tableName = CONF_DB_NAME . ".credentials";
    
    /** @var string Rótulo de identificação das credenciais */
    private string $credentialsLabel = "credentials_label";

    /** @var string Descrição das credenciais */
    private string $descriptionCredentials = "description_credentials";

    /** @var string Json que guarda as credenciais */
    private string $jsonCredentials = "json_credentials";

    /** @var string Token de autenticação */
    private string $tokenData = "token_data";

    /**
     * Credentials constructor
     */
    public function __construct()
    {
        parent::__construct($this->tableName, ["id"], [$this->credentialsLabel, $this->descriptionCredentials, $this->jsonCredentials, $this->tokenData]);
    }
}
