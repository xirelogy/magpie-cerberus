<?php

namespace MagpieLib\Cerberus\Objects\Traits;

use Magpie\Exceptions\NullException;
use Magpie\Models\Identifier;
use MagpieLib\Cerberus\Objects\Definitions\BaseDefinition;

/**
 * Forward functions from definition
 */
trait ForwardFromDefinition
{
    /**
     * Forward getId()
     * @return Identifier|string|int
     */
    public function getId() : Identifier|string|int
    {
        return $this->getDefinition()->getId();
    }


    /**
     * Forward getCode()
     * @return string
     * @throws NullException
     */
    public function getCode() : string
    {
        return $this->getDefinition()->getCode();
    }


    /**
     * Forward getDesc()
     * @return string
     */
    public function getDesc() : string
    {
        return $this->getDefinition()->getDesc();
    }


    /**
     * Get the definition
     * @return BaseDefinition
     */
    protected abstract function getDefinition() : BaseDefinition;
}