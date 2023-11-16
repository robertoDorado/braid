<?php
namespace Source\Domain\Model;

use Source\Models\EvaluationDesigner as ModelsEvaluationDesigner;

/**
 * EvaluationDesigner Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class EvaluationDesigner
{
    private Designer $designer;

    private int $ratingData;

    private string $evaluationDescription;

    private ModelsEvaluationDesigner $evaluationDesigner;

    public function setEvaluationDesigner(EvaluationDesigner $obj)
    {
        $getter = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getter) && is_array($isMethods)) {
            $this->evaluationDesigner = new ModelsEvaluationDesigner();
            $this->evaluationDesigner->designer_id = $this->getDesigner()->getId();
            $this->evaluationDesigner->rating_data = empty($this->getRatingData()) ? 0 : $this->getRatingData();
            $this->evaluationDesigner->evaluation_description = $this->getEvaluationDescription();
            if (!$this->evaluationDesigner->save()) {
                throw new \Exception($this->evaluationDesigner->fail());
            }
        }
    }

    public function getEvaluationLeftJoinDesigner(int $designerId = 0, int $limitValue = 0, bool $orderBy = false)
    {
        $this->evaluationDesigner = new ModelsEvaluationDesigner();

        $terms = "";
        $params = "";

        if (!empty($designerId)) {
            $terms = "id=:id";
            $params = ":id=" . $designerId . "";
        }

        $evaluationDesignerData = $this->evaluationDesigner
        ->find("", null, "rating_data, evaluation_description")
        ->advancedLeftJoin("designer",
        "braid.designer.id = braid.evaluation_designer.designer_id",
        $terms, $params);

        if (!empty($limitValue)) {
            $evaluationDesignerData->limit($limitValue);
        }

        if ($orderBy) {
            $evaluationDesignerData->order("braid.evaluation_designer.id", $orderBy);
        }

        $evaluationDesignerData = $evaluationDesignerData->fetch(true);
        return $evaluationDesignerData;
    }

    public function getEvaluationDescription()
    {
        return $this->evaluationDescription;
    }

    public function setEvaluationDescription(string $evaluationDescription)
    {
        if (strlen($evaluationDescription) > 1000) {
            throw new \Exception("Descrição sobre a avaliação está acima de 1000 caracteres");
        }
        $this->evaluationDescription = $evaluationDescription;
    }

    public function getRatingData()
    {
        return $this->ratingData;
    }

    public function setRatingData(int $rating)
    {
        if ($rating > 5) {
            throw new \Exception("Classificação não pode ser acima de 5 estrelas");
        }

        $this->ratingData = $rating;
    }

    public function getDesigner()
    {
        return $this->designer;
    }

    public function setDesigner(Designer $designer)
    {
        $this->designer = $designer;
    }
}
