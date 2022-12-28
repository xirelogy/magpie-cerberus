<?php

namespace MagpieLib\Cerberus\Configs;

use MagpieLib\Cerberus\Concepts\Configs\RoleDefinitionCreatable;
use MagpieLib\Cerberus\Objects\Definitions\RoleDefinition;

/**
 * Default implementation of RoleDefinitionCreatable
 */
class DefaultRoleDefinitionCreator implements RoleDefinitionCreatable
{
    /**
     * @inheritDoc
     */
    public function create(string $id) : RoleDefinition
    {
        return RoleDefinition::createInstanceWithId($id);
    }
}