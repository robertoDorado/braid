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

    public function testGetJobs()
    {
        $this->contract = new Contract();
        $this->contract->setJobs([
            'job1',
            'job2',
            'job3',
            'job4'
        ]);

        $jobs = $this->contract->getJobs();
        $this->assertIsArray($jobs);
    }

    public function testGetJobsAsString()
    {
        $this->contract = new Contract();
        $this->contract->setJobs(['job1', 'job2', 'job3', 'job4']);
        $jobs = $this->contract->getJobsAsString();
        $this->assertIsString($jobs);
    }

    public function testGetJobsDescription()
    {
        $this->contract = new Contract();
        $this->contract->setJobsDescription([
            'description 1',
            'description 2',
            'description 3',
            'description 4'
        ]);

        $jobsDescription = $this->contract->getJobsDescription();
        $this->assertIsArray($jobsDescription);
    }

    public function testGetJobsDescriptionAsString()
    {
        $this->contract = new Contract();
        $this->contract->setJobsDescription(['description 1', 'description 2', 'description 3', 'description 4']);
        $jobs = $this->contract->getJobsDescriptionAsString();
        $this->assertIsString($jobs);
    }

    public function testGetTimestampJobs()
    {
        $this->contract = new Contract();
        $timestampJobs = formatDateTime("+5 days", ...[11, 20, 15]);
        $this->contract->setTimestampJobs($timestampJobs);
        $jobTime = $this->contract->getTimestampJobs();

        $this->assertMatchesRegularExpression('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $jobTime);
    }

    public function testGetRemuneration()
    {
        $this->contract = new Contract();
        $this->contract->setRemuneration(1550.45);
        $remuneration = $this->contract->getRemuneration();

        $this->assertIsFloat($remuneration);
    }

    public function testGetIntellectualProperty()
    {
        $this->contract = new Contract();
        $this->contract->setIntellectualProperty("Terms of intellectual property...");

        $intellectualProperty = $this->contract->getIntellectualProperty();
        $this->assertIsString($intellectualProperty);
    }

    public function testGetEmptyIntellectualProperty()
    {
        $this->contract = new Contract();
        $this->contract->setIntellectualProperty('');
        $intellectualProperty = $this->contract->getIntellectualProperty();
        $this->assertNull($intellectualProperty);
    }

    public function testGetEmptyIntellectualProperty2()
    {
        $this->contract = new Contract();
        $intellectualProperty = $this->contract->getIntellectualProperty();
        $this->assertNull($intellectualProperty);
    }

    public function testGetConfidentiality()
    {
        $this->contract = new Contract();
        $this->contract->setConfidentiality("Terms of confidentiality");

        $termsOfConfidentiality = $this->contract->getConfidentiality();
        $this->assertIsString($termsOfConfidentiality);
    }


    public function testGetEmptyConfidentiality()
    {
        $this->contract = new Contract();
        $this->contract->setConfidentiality('');
        $confidentiality = $this->contract->getConfidentiality();
        $this->assertNull($confidentiality);
    }

    public function testGetEmptyConfidentiality2()
    {
        $this->contract = new Contract();
        $termsOfConfidentiality = $this->contract->getConfidentiality();
        $this->assertNull($termsOfConfidentiality);
    }

    public function testGetTerminationOfContract()
    {
        $this->contract = new Contract();
        $terminationOfContract = formatDate("+2 days");
        $this->contract->setTerminationOfContract($terminationOfContract);

        $terminationOfContract = $this->contract->getTerminationOfContract();
        $this->assertMatchesRegularExpression("/^\d{4}-\d{2}-\d{2}$/", $terminationOfContract);
    }

    public function testGetEmptyTerminationOfContract()
    {
        $this->contract = new Contract();
        $this->contract->setTerminationOfContract('');
        $terminationOfContract = $this->contract->getTerminationOfContract();
        $this->assertNull($terminationOfContract);
    }

    public function testGetEmptyTerminationOfContract2()
    {
        $this->contract = new Contract();
        $terminationOfContract = $this->contract->getTerminationOfContract();
        $this->assertNull($terminationOfContract);
    }

    public function testGetAdditionalClauses()
    {
        $this->contract = new Contract();
        $this->contract->setAdditionalClauses("Additional Clauses...");

        $additionalClauses = $this->contract->getAdditionalClauses();
        $this->assertIsString($additionalClauses);
    }

    public function testGetEmptyAdditionalClauses()
    {
        $this->contract = new Contract();
        $this->contract->setAdditionalClauses('');
        $additionalClauses = $this->contract->getAdditionalClauses();
        $this->assertNull($additionalClauses);
    }

    public function testGetEmptyAdditionalClauses2()
    {
        $this->contract = new Contract();
        $additionalClauses = $this->contract->getAdditionalClauses();
        $this->assertNull($additionalClauses);
    }

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

    public function testGetSignatureBusinessMan()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureBusinessMan("data:image/png;base64,iVBORw0K...");

        $signature = $this->contract->getSignatureBusinessMan();
        $this->assertIsString($signature);
    }

    public function testGetSignatureDesigner()
    {
        $this->contract = new Contract();
        $this->contract->setSignatureDesigner("data:image/png;base64,iVBORw0K...");

        $signature = $this->contract->getSignatureDesigner();
        $this->assertIsString($signature);
    }
}
