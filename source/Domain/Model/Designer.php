<?php

namespace Source\Domain\Model;

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

    /** @var string[] Objetivos */
    private array $goalsData = [];

    /** @var string[] Qualificações */
    private array $qualificationsData = [];

    /** @var string[] Portfólio */
    private array $portfolioData = [];

    /** @var string[] Experiência */
    private array $experienceData = [];

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
            $this->designer->experience_data = empty($this->getExperienceAsString()) ? null : $this->getExperienceAsString();
            $this->designer->portfolio_data = empty($this->getPortfolioAsString()) ? null : $this->getPortfolioAsString();
            $this->designer->qualifications_data = empty($this->getQualificationAsString()) ? null : $this->getQualificationAsString();
            $this->designer->biography_data = empty($this->getBiography()) ? null : $this->getBiography();
            $this->designer->goals_data = empty($this->getGoalsAsString()) ? null : $this->getGoalsAsString();
            if (!$this->designer->save()) {
                throw new \Exception($this->designer->fail());
            }

            $this->id = Connect::getInstance()->lastInsertId();
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

    public function setExperience(array $experience)
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

    public function getExperienceAsString()
    {
        if (empty($this->experienceData)) {
            return null;
        }

        $experience = implode(";", $this->experienceData);
        return $experience;
    }

    public function setPortfolio(array $portfolio)
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

    public function getPortfolioAsString()
    {
        if (empty($this->portfolioData)) {
            return null;
        }

        $portfolio = implode(";", $this->portfolioData);
        return $portfolio;
    }

    public function setQualifications(array $qualifications)
    {
        $this->qualificationsData = $qualifications;
    }

    public function getQualifications()
    {
        return $this->qualificationsData;
    }

    public function getQualificationAsString()
    {
        if (!empty($this->qualificationsData)) {
            $qualifications = implode(";", $this->qualificationsData);
            return $qualifications;
        }
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

    public function setGoals(array $goals)
    {
        $this->goalsData = $goals;
    }

    public function getGoals()
    {
        return $this->goalsData;
    }

    public function getGoalsAsString()
    {
        if (!empty($this->goalsData)) {
            $goals = implode(";", $this->goalsData);
            return $goals;
        }
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
