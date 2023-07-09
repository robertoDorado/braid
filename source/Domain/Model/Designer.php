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

    public function setContract(int $id, Contract $contract)
    {
        $this->contracts[$id] = $contract;
    }

    /**
     * @return Contract[]
     */
    public function getContract()
    {
        return $this->contracts;
    }
}
