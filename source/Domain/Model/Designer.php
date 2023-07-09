<?php

namespace Source\Domain\Model;

/**
 * Designer Source\Domain\Model
 * @link 
 * @author Roberto Dorado <robertodorado7@gmail.com>
 * @package Source\Domain\Model
 */
class Designer
{
    /** @var Contract[] */
    private array $contracts;

    /**
     * Designer constructor
     */
    public function __construct()
    {
    }

    public function setContract(Contract $contract)
    {
        $this->contracts = $contract;
    }

    /**
     * @return Contract[]
     */
    public function getContract()
    {
        return $this->contracts;
    }
}
