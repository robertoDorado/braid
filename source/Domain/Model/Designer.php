<?php

namespace Source\Domain\Model;

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

    public function setExperience(array $experience)
    {
        $this->experience = $experience;
    }

    public function getExperience(): array
    {
        return $this->experience;
    }

    public function setPortfolio(array $portfolio)
    {
        $this->portfolio = $portfolio;
    }

    public function getPortfolio(): array
    {
        return $this->portfolio;
    }

    public function setQualifications(array $qualifications)
    {
        $this->qualifications = $qualifications;
    }

    public function getQualifications(): array
    {
        return $this->qualifications;
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

    public function setContract(int $id, Contract $contract)
    {
        $this->contracts[$id] = $contract;
    }

    /**
     * @return Contract[]
     */
    public function getContract()
    {
        return $this->contracts;
    }
}
