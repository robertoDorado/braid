<?php

namespace Source\Domain\Model;

/**
 * Contract Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Contract
{
    /** @var BusinessMan */
    private BusinessMan $businessMan;

    /** @var Designer */
    private Designer $designer;

    /**
     * Contract constructor
     */
    public function __construct()
    {
    }

    public function setDesigner(Designer $designer)
    {
        $this->designer = $designer;
    }

    public function getDesigner(): Designer
    {
        return $this->designer;
    }

    public function setBusinessMan(BusinessMan $businessMan)
    {
        $this->businessMan = $businessMan;
    }

    public function getBusinessMan(): BusinessMan
    {
        return $this->businessMan;
    }
}
