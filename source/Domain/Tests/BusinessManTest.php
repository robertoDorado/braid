<?php
namespace Source\Domain\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Contract;

/**
 * BusinessManTest Source\Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class BusinessManTest extends TestCase
{
    /** @var BusinessMan Objeto BusinessMan */
    private BusinessMan $businessMan;

    public function testGetCeoName()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setCeoName("Jhon Doe");

        $ceoName = $this->businessMan->getCeoName();
        $this->assertIsString($ceoName);
    }

    public function testGetCompanyName()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setCompanyName("Nabucodonosor");

        $companyName = $this->businessMan->getCompanyName();
        $this->assertIsString($companyName);
    }

    public function testGetDescriptionCompany()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setDescriptionCompany("My company its a reference of Matrix");

        $descriptionCompany = $this->businessMan->getDescriptionCompany();
        $this->assertIsString($descriptionCompany);
    }

    public function testGetBranchOfCompany()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setBranchOfCompany("A movie of Matrix");

        $branchOfCompany = $this->businessMan->getBranchOfCompany();
        $this->assertIsString($branchOfCompany);
    }

    public function testGetContract()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setContract(new Contract());
        $this->businessMan->setContract(new Contract());

        $contracts = $this->businessMan->getContracts();
        foreach ($contracts as $contract) {
            $this->assertInstanceOf(Contract::class, $contract);
        }
    }

    public function testGetContracts()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setContract(new Contract());
        $this->businessMan->setContract(new Contract());

        $contracts = $this->businessMan->getContracts();
        $this->assertIsArray($contracts);
    }

    public function testIsValidCompanyTrue()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setValidCompany(true);

        $isValidCompany = $this->businessMan->isValidCompany();
        $this->assertIsBool($isValidCompany);
    }

    public function testGetRegisterNumber()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setRegisterNumber("93.530.879/0001-64");

        $number = $this->businessMan->getRegisterNumber();
        $this->assertIsString($number);
    }

    public function testGetTotalData()
    {
        $this->businessMan = new BusinessMan();
        $this->assertIsInt($this->businessMan->getTotalData());
    }
}
