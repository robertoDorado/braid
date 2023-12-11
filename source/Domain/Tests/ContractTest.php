<?php

namespace Source\Domain\Tests;

use PDOException;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\Contract;
use Source\Domain\Model\Designer;
use Source\Domain\Model\Jobs;

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

    public function testGetJob()
    {
        $this->contract = new Contract();
        $this->contract->setJobs(new Jobs());

        $job = $this->contract->getJobs();
        $this->assertInstanceOf(Jobs::class, $job);
    }

    public function testGetDesigner()
    {
        $this->contract = new Contract();
        $this->contract->setDesigner(new Designer());

        $designer = $this->contract->getDesigner();
        $this->assertInstanceOf(Designer::class, $designer);
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

    public function testGetAdditionalDescription()
    {
        $this->contract = new Contract();
        $this->contract->setAdditionalDescription("Description data");

        $descriptionData = $this->contract->getAdditionalDescription();
        $this->assertIsString($descriptionData);
    }

    public function testSetModelContract()
    {
        $this->contract = new Contract();
        $designer = new Designer();
        $job = new Jobs();
        $designer->setId(0);
        $job->setId(0);
        
        $this->contract->setDesigner($designer);
        $this->contract->setJobs($job);
        $this->contract->setAdditionalDescription("");
        $this->contract->setSignatureBusinessMan(false);
        $this->contract->setSignatureDesigner(false);
        $this->expectException(PDOException::class);
        $this->contract->setModelContract($this->contract);
    }

    public function testDestroyContractByJob()
    {
        $this->contract = new Contract();
        $jobs = new Jobs();
        $jobs->setId(0);
        $this->contract->setJobs($jobs);
        $this->assertEmpty($this->contract->destroyContractByJob());
    }

    public function testGetTotalContractLeftJoinDesigner()
    {
        $this->contract = new Contract();
        $contractsData = $this->contract->getTotalContractLeftJoinDesigner(0);
        $this->assertEmpty($contractsData);
    }

    public function testGetContractLeftJoinDesignerA()
    {
        $this->contract = new Contract();
        $contractsData = $this->contract->getContractLeftJoinDesigner(0, true);
        $this->assertEmpty($contractsData);
    }
    
    public function testGetContractLeftJoinDesignerB()
    {
        $this->contract = new Contract();
        $contractsData = $this->contract->getContractLeftJoinDesigner(0);
        $this->assertIsObject($contractsData);
    }

    public function testGetContractByDesignerIdAndJobId()
    {
        $this->contract = new Contract();
        $contractsData = $this->contract->getContractByDesignerIdAndJobId(0, 0);
        $this->assertEmpty($contractsData);
    }
}
