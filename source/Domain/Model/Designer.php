<?php

namespace Source\Domain\Model;

use Source\Core\Connect;
use Source\Models\Designer as ModelsDesigner;

/**
 * Designer Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Designer
{
    /** @var int Ultimo id inserido na tabela Designer */
    private int $id;

    /** @var string Nome do Designer  */
    private string $name;

    /** @var string E-mail do designer */
    private string $email;

    /** @var string Número do CPF */
    private string $document = '';

    /** @var string $biografia */
    private string $biography = '';

    /** @var string[] Objetivos */
    private array $goals = [];

    /** @var string[] Qualificações do designer */
    private array $qualifications = [];

    /** @var string[] Portfólio do designer */
    private array $portfolio = [];

    /** @var string[] Experiência do designer */
    private array $experience = [];

    /** @var Contract[] */
    private array $contracts = [];

    /** @var ModelsDesigner Model Designer */
    private ModelsDesigner $designer;

    public function setModelDesigner(Designer $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->designer = new ModelsDesigner();
            $this->designer->name = $this->getDesignerName();
            $this->designer->email = $this->getEmail();
            $this->designer->document = empty($this->getDocument()) ? null : $this->getDocument();
            $this->designer->experience = empty($this->getExperienceAsString()) ? null : $this->getExperienceAsString();
            $this->designer->portfolio = empty($this->getPortfolioAsString()) ? null : $this->getPortfolioAsString();
            $this->designer->qualifications = empty($this->getQualificationAsString()) ? null : $this->getQualificationAsString();
            $this->designer->biography = empty($this->getBiography()) ? null : $this->getBiography();
            $this->designer->goals = empty($this->getGoalsAsString()) ? null : $this->getGoalsAsString();
            if (!$this->designer->save()) {
                throw new \Exception($this->designer->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function getTotalData()
    {
        $this->designer = new ModelsDesigner();
        return $this->designer->find('')->count();
    }

    public function setDocument(string $number)
    {
        if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $number)) {
            throw new \Exception("Número de CPF Inválido");
        }

        $this->document = $number;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getId()
    {
        if (empty($this->id)) {
            return null;
        }
        return $this->id;
    }

    public function setExperience(array $experience)
    {
        $this->experience = $experience;
    }

    public function getExperience()
    {
        if (empty($this->experience)) {
            return null;
        }
        return $this->experience;
    }

    public function getExperienceAsString()
    {
        if (empty($this->experience)) {
            return null;
        }

        $experience = implode(";", $this->experience);
        return $experience;
    }

    public function setPortfolio(array $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function getPortfolio()
    {
        if (empty($this->portfolio)) {
            return null;
        }
        return $this->portfolio;
    }

    public function getPortfolioAsString()
    {
        if (empty($this->portfolio)) {
            return null;
        }

        $portfolio = implode(";", $this->portfolio);
        return $portfolio;
    }

    public function setQualifications(array $qualifications)
    {
        $this->qualifications = $qualifications;
    }

    public function getQualifications()
    {
        return $this->qualifications;
    }

    public function getQualificationAsString()
    {
        if (!empty($this->qualifications)) {
            $qualifications = implode(";", $this->qualifications);
            return $qualifications;
        }
    }

    public function getDesignerName()
    {
        return $this->name;
    }

    public function setDesignerName(string $name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $emailData = (new ModelsDesigner())
            ->find('email=:email', ':email=' . $email . '', 'email')
            ->fetch();

        if (!empty($emailData)) {
            echo json_encode(['email_already_exists' => true]);
            return;
        }

        $this->email = $email;
    }

    public function setBiography(string $biography)
    {
        $this->biography = $biography;
    }

    public function getBiography()
    {
        return $this->biography;
    }

    public function setGoals(array $goals)
    {
        $this->goals = $goals;
    }

    public function getGoals()
    {
        return $this->goals;
    }

    public function getGoalsAsString()
    {
        if (!empty($this->goals)) {
            $goals = implode(";", $this->goals);
            return $goals;
        }
    }

    public function setContract(Contract $contract)
    {
        $this->contracts[] = $contract;
    }

    /**
     * @return Contract[]|null
     */
    public function getContract()
    {
        if (empty($this->contracts)) {
            return null;
        }
        return $this->contracts;
    }
}
