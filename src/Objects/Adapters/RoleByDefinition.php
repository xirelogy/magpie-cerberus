<?php

namespace MagpieLib\Cerberus\Objects\Adapters;

use MagpieLib\Cerberus\Objects\Definitions\RoleDefinition;
use MagpieLib\Cerberus\Objects\Role;
use MagpieLib\Cerberus\Objects\Traits\ForwardFromDefinition;

/**
 * Adapt RoleDefinition into a Role
 */
class RoleByDefinition extends Role
{
    use ForwardFromDefinition;


    /**
     * @var RoleDefinition Associated definition
     */
    protected readonly RoleDefinition $def;


    /**
     * Constructor
     * @param RoleDefinition $def
     */
    public function __construct(RoleDefinition $def)
    {
        $this->def = $def;
    }


    /**
     * @inheritDoc
     */
    protected function onGetFeatures() : iterable
    {
        return $this->getDefinition()->getFeatures();
    }


    /**
     * @inheritDoc
     */
    protected function onIsNeedTenant() : bool
    {
        return $this->getDefinition()->isNeedTenant();
    }


    /**
     * @inheritDoc
     */
    protected function onIsRoot() : bool
    {
        return $this->getDefinition()->isRoot();
    }


    /**
     * @inheritDoc
     */
    protected function getDefinition() : RoleDefinition
    {
        return $this->def;
    }
}