<?php

namespace Heystack\Subsystem\Core\Identifier;

/**
 * Class Identifier
 * @author Cam Spiers <cameron@heyday.co.nz>
 * @package Heystack\Subsystem\Core\Identifier
 */
class Identifier implements IdentifierInterface
{
    /**
     * @var
     */
    protected $primary;
    /**
     * @var array
     */
    protected $secondaries = array();
    /**
     * @param $primary
     * @param array $secondaries
     */
    public function __construct($primary, array $secondaries = null)
    {
        $this->primary = $primary;
        if (is_array($secondaries)) {
            $this->secondaries = $secondaries;
        }
    }
    /**
     * @return
     */
    public function getPrimary()
    {
        return $this->primary;
    }
    /**
     * @return array
     */
    public function getSecondaries()
    {
        return $this->secondaries;
    }
    /**
     * @param IdentifierInterface $identifier
     * @return bool
     */
    public function isMatch(IdentifierInterface $identifier)
    {
        return $this->primary === $identifier->getPrimary();
    }
    /**
     * @param IdentifierInterface $identifier
     * @return bool
     */
    public function isMatchStrict(IdentifierInterface $identifier)
    {
        return $this->isMatch($identifier) && $this->secondaries === $identifier->getSecondaries();
    }
}