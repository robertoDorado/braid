<?php

namespace Source\Domain\Tests;

use DateTime;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Contract;
use Source\Domain\Model\Designer;

/**
 * ContractTest Source\Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class ContractTest extends TestCase
{
    /** @var Contract Objeto contrato */
    private Contract $contract;

    public function testGetDesigner()
    {
        $this->contract = new Contract();
        $this->contract->setDesigner(new Designer());

        $designer = $this->contract->getDesigner();
        $this->assertInstanceOf(Designer::class, $designer);
    }

    public function testGetBusinessMan()
    {
        $this->contract = new Contract();
        $this->contract->setBusinessMan(new BusinessMan());

        $businessman = $this->contract->getBusinessMan();

        $this->assertInstanceOf(BusinessMan::class, $businessman);
    }

    public function testGetSignatureBusinessManA()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureBusinessMan(true);

        $signature = $this->contract->getSignatureBusinessMan();
        $this->assertIsBool($signature);
    }

    public function testGetSignatureBusinessManB()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureBusinessMan(false);

        $signature = $this->contract->getSignatureBusinessMan();
        $this->assertIsBool($signature);
    }

    public function testGetSignatureDesignerA()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureDesigner(true);

        $signature = $this->contract->getSignatureDesigner();
        $this->assertIsBool($signature);
    }

    public function testGetSignatureDesignerB()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureDesigner(false);

        $signature = $this->contract->getSignatureDesigner();
        $this->assertIsBool($signature);
    }

    public function setAdditionalDescription()
    {
        $this->contract = new Contract();
        $this->contract->setAdditionalDescription("Description data");

        $descriptionData = $this->contract->getAdditionalDescription();
        $this->assertIsString($descriptionData);
    }
}
