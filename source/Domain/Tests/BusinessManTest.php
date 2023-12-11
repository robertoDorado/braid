<?php
namespace Source\Domain\Tests;

use Exception;
use PDOException;
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

    public function testSetModelBusinessMan()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setCeoName("");
        $this->businessMan->setEmail("");
        $this->expectException(PDOException::class);
        $this->businessMan->setModelBusinessMan($this->businessMan);
    }

    public function testUpdateAdditionalData()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setEmail('');
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Objeto businessMan não encontrado");
        $this->businessMan->updateAdditionalData();
    }

    public function testUpdateNameEmailPhotoBusinessMan()
    {
        $this->businessMan = new BusinessMan();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Objeto businessMan não encontrado");
        $this->businessMan->updateNameEmailPhotoBusinessMan(['fullEmail' => '']);
    }

    public function testGetPathPhoto()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setPathPhoto('');
        $pathPhoto = $this->businessMan->getPathPhoto();
        $this->assertIsString($pathPhoto);
    }

    public function testGetBusinessManById()
    {
        $this->businessMan = new BusinessMan();
        $businessManData = $this->businessMan->getBusinessManById(0);
        $this->assertEmpty($businessManData);
    }

    public function testGetBusinessManByEmail()
    {
        $this->businessMan = new BusinessMan();
        $businessManData = $this->businessMan->getBusinessManByEmail('');
        $this->assertEmpty($businessManData);
    }

    public function testGetIdA()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setId(10);
        $id = $this->businessMan->getId();
        $this->assertEquals(10, $id);
    }

    public function testGetIdB()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setId(10);
        $id = $this->businessMan->getId();
        $this->assertIsInt($id);
    }

    public function testGetEmail()
    {
        $this->businessMan = new BusinessMan();
        $this->businessMan->setEmail('');
        $emailData = $this->businessMan->getEmail();
        $this->assertEmpty($emailData);
    }
}
