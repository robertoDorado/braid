<?php
namespace Source\Domain\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\Contract;
use Source\Domain\Model\Designer;

/**
 * DesignerTest Source\Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class DesignerTest extends TestCase
{
    /** @var Designer Objeto Designer */
    private Designer $designer;

    public function testGetExpirience()
    {
        $this->designer = new Designer();
        $this->designer->setExperience([
            'I have expirience in this area 1',
            'I have expirience in this area 2',
            'I have expirience in this area 3',
            'I have expirience in this area 4',
            'I have expirience in this area 5'
        ]);

        $expiriences = $this->designer->getExperience();
        $this->assertIsArray($expiriences);
    }

    public function testGetPortfolio()
    {
        $this->designer = new Designer();
        $this->designer->setPortfolio([
            'Portfolio 1',
            'Portfolio 2',
            'Portfolio 3',
            'Portfolio 4',
            'Portfolio 5'
        ]);

        $portfolio = $this->designer->getPortfolio();
        $this->assertIsArray($portfolio);
    }

    public function testGetQualifications()
    {
        $this->designer = new Designer();
        $this->designer->setQualifications([
            'Qualifications 1',
            'Qualifications 2',
            'Qualifications 3',
            'Qualifications 4',
            'Qualifications 5',
        ]);

        $qualifications = $this->designer->getQualifications();
        $this->assertIsArray($qualifications);
    }

    public function testDesignerName()
    {
        $this->designer = new Designer();
        $this->designer->setDesignerName("Jhon Doe");

        $designerName = $this->designer->getDesignerName();
        $this->assertIsString($designerName);
    }

    public function testGetBiography()
    {
        $this->designer = new Designer();
        $this->designer->setBiography("My biography is...");

        $biography = $this->designer->getBiography();
        $this->assertIsString($biography);
    }

    public function testGetGoals()
    {
        $this->designer = new Designer();
        $this->designer->setGoals([
            'My goal is 1',
            'My goal is 2',
            'My goal is 3',
            'My goal is 4',
            'My goal is 5'
        ]);

        $goals = $this->designer->getGoals();
        $this->assertIsArray($goals);
    }

    public function testGetContract()
    {
        $this->designer = new Designer();
        $this->designer->setContract(new Contract());
        $this->designer->setContract(new Contract());

        $contracts = $this->designer->getContract();
        foreach ($contracts as $contract) {
            $this->assertInstanceOf(Contract::class, $contract);
        }
    }

    public function testGetContracts()
    {
        $this->designer = new Designer();
        $this->designer->setContract(new Contract());
        $this->designer->setContract(new Contract());

        $contracts = $this->designer->getContract();
        $this->assertIsArray($contracts);
    }

    public function testGetExperienceAsString()
    {
        $this->designer = new Designer();
        $this->designer->setExperience(['EmpresaA', 'EmpresaB', 'EmpresaC', 'EmpresaD']);
        $experience = $this->designer->getExperienceAsString();
        $this->assertIsString($experience);
    }

    public function testGetEmptyExperience()
    {
        $this->designer = new Designer();
        $this->designer->setExperience([]);
        $experience = $this->designer->getExperienceAsString();
        $this->assertNull($experience);
    }

    public function testGetEmptyExperience2()
    {
        $this->designer = new Designer();
        $experience = $this->designer->getExperienceAsString();
        $this->assertNull($experience);
    }

    public function testGetPortfolioAsString()
    {
        $this->designer = new Designer();
        $this->designer->setPortfolio(['PortfolioA', 'PortfolioB', 'PortfolioC', 'PortfolioD']);
        $portfolio = $this->designer->getPortfolioAsString();
        $this->assertIsString($portfolio);
    }

    public function testGetEmptyPortfolio()
    {
        $this->designer = new Designer();
        $this->designer->setPortfolio([]);
        $portfolio = $this->designer->getPortfolioAsString();
        $this->assertNull($portfolio);
    }

    public function testGetEmptyPortfolio2()
    {
        $this->designer = new Designer();
        $portfolio = $this->designer->getPortfolioAsString();
        $this->assertNull($portfolio);
    }

    public function testGetQualificationsAsString()
    {
        $this->designer = new Designer();
        $this->designer->setQualifications(['QualificationA', 'QualificationB', 'QualificationC', 'QualificationD']);
        $qualifications = $this->designer->getQualificationAsString();
        $this->assertIsString($qualifications);
    }

    public function testGetGoalsAsString()
    {
        $this->designer = new Designer();
        $this->designer->setGoals(['GoalsA', 'GoalsB', 'GoalsC', 'GoalsD']);
        $goals = $this->designer->getGoalsAsString();
        $this->assertIsString($goals);
    }

    public function testGetDocument()
    {
        $this->designer = new Designer();
        $this->designer->setDocument("036.143.080-90");
        $document = $this->designer->getDocument();
        $this->assertIsString($document);
    }

    public function testGetDocumentException()
    {
        $this->designer = new Designer();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Número de CPF Inválido");
        $this->designer->setDocument("03614308090");
    }

    public function testGetTotalData()
    {
        $this->designer = new Designer();
        $this->assertIsInt($this->designer->getTotalData());
    }
}
