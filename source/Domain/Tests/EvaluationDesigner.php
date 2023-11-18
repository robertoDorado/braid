<?php
namespace Source\Domain\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Source\Domain\Model\BusinessMan;
use Source\Domain\Model\Designer;
use Source\Domain\Model\EvaluationDesigner as ModelEvaluationDesigner;

/**
 * EvaluationDesigner Domain\Tests
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Tests
 */
class EvaluationDesigner extends TestCase
{
    private ModelEvaluationDesigner $evaluationDesigner;

    public function testGetBusinessMan()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->evaluationDesigner->setBusinessMan(new BusinessMan());
        $businessMan = $this->evaluationDesigner->getBusinessMan();
        $this->assertInstanceOf(BusinessMan::class, $businessMan);
    }

    public function testGetDesigner()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->evaluationDesigner->setDesigner(new Designer());
        $designer = $this->evaluationDesigner->getDesigner();
        $this->assertInstanceOf(Designer::class, $designer);
    }

    public function testGetRatingData()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->evaluationDesigner->setRatingData(4);
        $rating = $this->evaluationDesigner->getRatingData();
        $this->assertIsInt($rating);
    }

    public function testExceptionRatingData()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Classificação não pode ser acima de 5 estrelas");
        $this->evaluationDesigner->setRatingData(6);
    }

    public function testGetEvaluationDescription()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->evaluationDesigner->setEvaluationDescription("teste teste");
        $evaluationDescription = $this->evaluationDesigner->getEvaluationDescription();
        $this->assertIsString($evaluationDescription);
    }

    public function testExceptionEvaluationDescription()
    {
        $this->evaluationDesigner = new ModelEvaluationDesigner();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Descrição sobre a avaliação está acima de 1000 caracteres");
        $this->evaluationDesigner->setEvaluationDescription("Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letrase");
    }
}
