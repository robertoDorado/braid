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
        $this->designer->setExperience('I have expirience in this area 1');

        $expiriences = $this->designer->getExperience();
        $this->assertIsString($expiriences);
    }

    public function testGetPortfolio()
    {
        $this->designer = new Designer();
        $this->designer->setPortfolio('Portfolio 1');

        $portfolio = $this->designer->getPortfolio();
        $this->assertIsString($portfolio);
    }

    public function testGetQualifications()
    {
        $this->designer = new Designer();
        $this->designer->setQualifications('Qualifications 1');

        $qualifications = $this->designer->getQualifications();
        $this->assertIsString($qualifications);
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
