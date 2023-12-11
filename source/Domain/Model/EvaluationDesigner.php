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
    private BusinessMan $businessMan;

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
            $this->evaluationDesigner->business_man_id = $this->getBusinessMan()->getId();
            $this->evaluationDesigner->designer_id = $this->getDesigner()->getId();
            $this->evaluationDesigner->rating_data = empty($this->getRatingData()) ? 0 : $this->getRatingData();
            $this->evaluationDesigner->evaluation_description = $this->getEvaluationDescription();
            if (!$this->evaluationDesigner->save()) {
                if (!empty($this->evaluationDesigner->fail())) {
                    throw new \PDOException($this->evaluationDesigner->fail()->getMessage() . " " . $this->evaluationDesigner->queryExecuted());
                }else {
                    throw new \PDOException($this->evaluationDesigner->message());
                }
            }
        }
    }

    public function getEvaluationLeftJoinDesigner(string $designerEmail = '', int $limitValue = 0, int $offsetValue = 0, bool $orderBy = false)
    {
        $this->evaluationDesigner = new ModelsEvaluationDesigner();

        $terms = "";
        $params = "";

        if (!empty($designerEmail)) {
            $terms = "full_email=:full_email";
            $params = ":full_email=" . $designerEmail . "";
        }

        $evaluationDesignerData = $this->evaluationDesigner
        ->find("", null, "rating_data, evaluation_description, business_man_id")
        ->advancedLeftJoin("designer",
        "braid.designer.id = braid.evaluation_designer.designer_id",
        $terms, $params);

        if (!empty($limitValue)) {
            $evaluationDesignerData->limit($limitValue);
        }

        if (!empty($offsetValue)) {
            $evaluationDesignerData->offset($offsetValue);
        }

        if ($orderBy) {
            $evaluationDesignerData->order("braid.evaluation_designer.id", $orderBy);
        }

        $evaluationDesignerData = $evaluationDesignerData->fetch(true);
        return empty($evaluationDesignerData) ? [] : $evaluationDesignerData;
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

    public function getBusinessMan()
    {
        return $this->businessMan;
    }

    public function setBusinessMan(BusinessMan $businessMan)
    {
        $this->businessMan = $businessMan;
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
