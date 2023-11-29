<?php

namespace Source\Domain\Model;

use Bissolli\ValidadorCpfCnpj\CPF;
use Source\Core\Connect;
use Source\Models\Designer as ModelsDesigner;

/**
 * Designer Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Designer
{
    /** @var int Ultimo id inserido na tabela Designer */
    private int $id = 0;

    /** @var string Nome  */
    private string $fullName;

    /** @var string E-mail */
    private string $fullEmail = '';

    /** @var string Cargo */
    private string $positionData = '';

    /** @var string Foto */
    private string $pathPhoto = '';

    /** @var string Número do CPF */
    private string $documentData = '';

    /** @var string $biografia */
    private string $biographyData = '';

    /** @var string Objetivos */
    private string $goalsData = '';

    /** @var string Qualificações */
    private string $qualificationsData = '';

    /** @var string Portfólio */
    private string $portfolioData = '';

    /** @var string Experiência */
    private string $experienceData = '';

    /** @var Contract[] */
    private array $contracts = [];

    /** @var ModelsDesigner Model Designer */
    private ModelsDesigner $designer;

    public function setModelDesigner(Designer $obj)
    {
        $getters = checkGettersFilled($obj);
        $isMethods = checkIsMethodsFilled($obj);

        if (is_array($getters) && is_array($isMethods)) {
            $this->designer = new ModelsDesigner();
            $this->designer->full_name = $this->getDesignerName();
            $this->designer->full_email = $this->getEmail();
            $this->designer->position_data = $this->getPositionData();
            $this->designer->path_photo = empty($this->getPathPhoto()) ? null : $this->getPathPhoto();
            $this->designer->document_data = empty($this->getDocument()) ? null : $this->getDocument();
            $this->designer->experience_data = empty($this->getExperience()) ? null : $this->getExperience();
            $this->designer->portfolio_data = empty($this->getPortfolio()) ? null : $this->getPortfolio();
            $this->designer->qualifications_data = empty($this->getQualifications()) ? null : $this->getQualifications();
            $this->designer->biography_data = empty($this->getBiography()) ? null : $this->getBiography();
            $this->designer->goals_data = empty($this->getGoals()) ? null : $this->getGoals();
            if (!$this->designer->save()) {
                throw new \Exception($this->designer->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
        }
    }

    public function updateAdditionalData()
    {
        $this->designer = new ModelsDesigner();
        $designerData = $this->designer
        ->find("full_email=:full_email", ":full_email=" . $this->getEmail() . "")->fetch();

        if (empty($designerData)) {
            throw new \Exception("Erro ao atualizar o objeto Designer");
        }

        $designerData->document_data = $this->getDocument();
        $designerData->biography_data = $this->getBiography();
        $designerData->goals_data = $this->getGoals();
        $designerData->qualifications_data = $this->getQualifications();
        $designerData->portfolio_data = $this->getPortfolio();
        $designerData->experience_data = $this->getExperience();
        $designerData->position_data = $this->getPositionData();
        if (!$designerData->save()) {
            throw new \Exception($designerData->fail());
        }
    }

    public function getPositionData()
    {
        return $this->positionData;
    }

    public function setPositionData(string $positionData)
    {
        $this->positionData = $positionData;
    }

    public function updateNameEmailPhotoDesigner(array $data)
    {
        $this->designer = new ModelsDesigner();
        $designerData = $this->designer
            ->find("full_email=:full_email", ":full_email=" . $data["fullEmail"] . "")->fetch();

        if (empty($designerData)) {
            return;
        }

        $designerData->full_name = $data["fullName"];
        $designerData->full_email = $data["fullEmail"];
        $designerData->path_photo = $data["pathPhoto"];
        if (!$designerData->save()) {
            throw new \Exception($designerData->fail());
        }
    }

    public function getPathPhoto()
    {
        return $this->pathPhoto;
    }

    public function setPathPhoto(string $pathPhoto)
    {
        $this->pathPhoto = $pathPhoto;
    }

    public function getDesignerById(int $id)
    {
        $this->designer = new ModelsDesigner();
        $designerData = $this->designer->findById($id);
        return $designerData;
    }

    public function getDesignerByEmail(string $email)
    {
        $designer = new ModelsDesigner();

        $designerData = $designer
            ->find("full_email=:full_email", ":full_email=" . $email . "")->fetch();

        return $designerData;
    }

    public function getTotalData()
    {
        $this->designer = new ModelsDesigner();
        return $this->designer->find('')->count();
    }

    public function setDocument(string $number)
    {
        if (!preg_match("/^\d{3}\.\d{3}\.\d{3}-\d{2}$/", $number)) {
            throw new \Exception("Número de CPF Inválido");
        }

        $document = new CPF($number);
        if (!$document->isValid()) {
            echo json_encode([
                "invalid_document" => true,
                "msg" => "CPF inválido"
            ]);
            die;
        }

        $this->documentData = $number;
    }

    public function getDocument()
    {
        return $this->documentData;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setExperience(string $experience)
    {
        $this->experienceData = $experience;
    }

    public function getExperience()
    {
        if (empty($this->experienceData)) {
            return null;
        }
        return $this->experienceData;
    }

    public function setPortfolio(string $portfolio)
    {
        $this->portfolioData = $portfolio;
    }

    public function getPortfolio()
    {
        if (empty($this->portfolioData)) {
            return null;
        }
        return $this->portfolioData;
    }

    public function setQualifications(string $qualifications)
    {
        $this->qualificationsData = $qualifications;
    }

    public function getQualifications()
    {
        return $this->qualificationsData;
    }

    public function getDesignerName()
    {
        return $this->fullName;
    }

    public function setDesignerName(string $name)
    {
        $this->fullName = $name;
    }

    public function getEmail()
    {
        return $this->fullEmail;
    }

    public function setEmail(string $email)
    {
        $emailData = (new ModelsDesigner())
            ->find('full_email=:full_email', ':full_email=' . $email . '', 'email')
            ->fetch();

        if (!empty($emailData)) {
            echo json_encode(['email_already_exists' => true]);
            die;
        }

        $this->fullEmail = $email;
    }

    public function setBiography(string $biography)
    {
        $this->biographyData = $biography;
    }

    public function getBiography()
    {
        return $this->biographyData;
    }

    public function setGoals(string $goals)
    {
        $this->goalsData = $goals;
    }

    public function getGoals()
    {
        return $this->goalsData;
    }

    public function setContract(Contract $contract)
    {
        $this->contracts[] = $contract;
    }

    /**
     * @return Contract[]|null
     */
    public function getContract()
    {
        if (empty($this->contracts)) {
            return null;
        }
        return $this->contracts;
    }
}
