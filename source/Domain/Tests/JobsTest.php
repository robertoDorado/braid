<?php
namespace Source\Domain\Tests;

use PHPUnit\Framework\TestCase;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Jobs;

/**
 * JobsTest Source\Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class JobsTest extends TestCase
{
    /** @var Jobs Objeto Jobs */
    private Jobs $jobs;

    public function testGetJobName()
    {
        $this->jobs = new Jobs();
        $this->jobs->setJobName("Layout para pizzaria e esfiharia");
        $job = $this->jobs->getJobName();
        $this->assertIsString($job);
    }

    public function testGetJobDescription()
    {
        $this->jobs = new Jobs();
        $this->jobs->setJobDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s");
        $job = $this->jobs->getJobDescription();
        $this->assertIsString($job);
    }

    public function testGetRemuneration()
    {
        $this->jobs = new Jobs();
        $this->jobs->setRemuneration(4250.45);
        $remuneration = $this->jobs->getRemuneration();
        $this->assertIsFloat($remuneration);
    }

    public function testGetDeliveryTime()
    {
        $this->jobs = new Jobs();
        $deliveryTime = formatDateTime("+5 days", ...[14, 15, 0]);
        $this->jobs->setDeliveryTime($deliveryTime);
        $deliveryTime = $this->jobs->getDeliveryTime();
        $this->assertMatchesRegularExpression("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $deliveryTime);
    }

    public function testGetBusinessMan()
    {
        $this->jobs = new Jobs();
        $this->jobs->setBusinessMan(new BusinessMan());
        $this->jobs->setBusinessMan(new BusinessMan());
        $businessMans = $this->jobs->getBusinessMan();
        
        foreach ($businessMans as $businessMan) {
            $this->assertInstanceOf(BusinessMan::class, $businessMan);
        }
    }

    public function testConverStringCurrencyToFloatA()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("R$ 2.455,22");
        $this->assertIsFloat($value);
    }

    public function testConverStringCurrencyToFloatB()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("2.455,22");
        $this->assertIsFloat($value);
    }

    public function testConverStringCurrencyToFloatC()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("2455.22");
        $this->assertIsFloat($value);
    }

    public function testConverStringCurrencyToFloatD()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("   2455.22    ");
        $this->assertIsFloat($value);
    }

    public function testConverStringCurrencyToFloatE()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("2455,22");
        $this->assertIsFloat($value);
    }

    public function testConverStringCurrencyToFloatF()
    {
        $this->jobs = new Jobs();
        $value = $this->jobs->convertCurrencyRealToFloat("   2455,22   ");
        $this->assertIsFloat($value);
    }
}
