<?php

namespace Source\Domain\Model;

use Source\Models\Designer as ModelsDesigner;

/**
 * Designer Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Designer
{
    /** @var string Nome do Designer  */
    private string $designerName;

    /** @var string $biografia */
    private string $biography;

    /** @var string[] Objetivos */
    private array $goals;

    /** @var string[] Qualificações do designer */
    private array $qualifications;

    /** @var string[] Portfólio do designer */
    private array $portfolio;

    /** @var string[] Experiência do designer */
    private array $experience;

    /** @var Contract[] */
    private array $contracts;

    /** @var ModelsDesigner Model Designer */
    private ModelsDesigner $designer;

    public function setModelDesigner(Designer $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->designer = new ModelsDesigner();
            $this->designer->name = $this->getDesignerName();
            $this->designer->experience = $this->getExperienceAsString();
            $this->designer->portfolio = $this->getPortfolioAsString();
            $this->designer->qualifications = $this->getQualificationAsString();
            $this->designer->biography = $this->getBiography();
            $this->designer->goals = $this->getGoalsAsString();
            if (!$this->designer->save()) {
                throw new \Exception($this->designer->fail());
            }
        }
    }

    public function setExperience(array $experience)
    {
        $this->experience = $experience;
    }

    public function getExperience(): array
    {
        return $this->experience;
    }

    public function getExperienceAsString()
    {
        if (!empty($this->experience)) {
            $experience = implode(";", $this->experience);
            return $experience;
        }

        return null;
    }

    public function setPortfolio(array $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function getPortfolio(): array
    {
        return $this->portfolio;
    }

    public function getPortfolioAsString()
    {
        if (!empty($this->portfolio)) {
            $portfolio = implode(";", $this->portfolio);
            return $portfolio;
        }

        return null;
    }

    public function setQualifications(array $qualifications)
    {
        $this->qualifications = $qualifications;
    }

    public function getQualifications(): array
    {
        return $this->qualifications;
    }

    public function getQualificationAsString(): string
    {
        if (!empty($this->qualifications)) {
            $qualifications = implode(";", $this->qualifications);
            return $qualifications;
        }
    }

    public function getDesignerName(): string
    {
        return $this->designerName;
    }

    public function setDesignerName(string $designerName)
    {
        $this->designerName = $designerName;
    }

    public function setBiography(string $biography)
    {
        $this->biography = $biography;
    }

    public function getBiography(): string
    {
        return $this->biography;
    }

    public function setGoals(array $goals)
    {
        $this->goals = $goals;
    }

    public function getGoals(): array
    {
        return $this->goals;
    }

    public function getGoalsAsString(): string
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
     * @return Contract[]
     */
    public function getContract()
    {
        return $this->contracts;
    }
}
