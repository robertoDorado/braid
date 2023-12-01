<?php

namespace Source\Domain\Model;

use Source\Models\Credentials as ModelsCredentials;

/**
 * Credentials Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Credentials
{
    /** @var ModelsCredentials Modelo Credenciais */
    private ModelsCredentials $credentials;

    public function __construct()
    {
        $this->credentials = new ModelsCredentials();
    }

    public function getCredentials(array $data, bool $isJson = false)
    {
        if ($this->credentials instanceof ModelsCredentials) {
            if (empty($data)) {
                throw new \Exception("Parâmetro obrigatório para criar novas credenciais");
            }

            $terms = '';
            $params = '';

            foreach ($data as $key => $value) {
                $terms .= "{$key}=:{$key} AND ";
                $params .= ":{$key}={$value}&";
            }

            $terms = removeLastStringOcurrence($terms, "AND");
            $params = removeLastStringOcurrence($params, "&");

            $credentials = $this->credentials->find($terms, $params)->fetch();

            if (empty($credentials)) {
                return null;
            }

            $data = json_decode($credentials->json_credentials);
            $response = [
                "userName" => $data->userName,
                "fullEmail" => $data->fullEmail,
                "tokenData" => $credentials->token_data
            ];

            return $isJson ? json_encode($response) : $response;
        } else {
            throw new \Exception("Erro ao tentar encontrar instância de credenciais");
        }
    }

    public function setCredentialsFromUser(array $data)
    {
        if ($this->credentials instanceof ModelsCredentials) {
            if (empty($data)) {
                throw new \Exception("Parâmetro obrigatório para criar novas credenciais");
            }

            $this->credentials->credentials_label = $data["credentialsLabel"];
            $this->credentials->description_credentials = $data["descriptionCredentials"];
            $this->credentials->json_credentials = $data["jsonCredentials"];
            $this->credentials->token_data = $data["tokenData"];
            if (!$this->credentials->save()) {
                if (!empty($this->credentials->fail())) {
                    throw new \PDOException($this->credentials->fail()->getMessage());
                }else {
                    throw new \PDOException($this->credentials->message());
                }
            }
        } else {
            throw new \Exception("Erro ao tentar encontrar instância de credenciais");
        }
    }
}
