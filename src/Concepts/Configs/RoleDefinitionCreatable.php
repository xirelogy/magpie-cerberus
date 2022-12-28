<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use MagpieLib\Cerberus\Objects\Definitions\RoleDefinition;

/**
 * May create instance of feature definition
 */
interface RoleDefinitionCreatable extends DefinitionCreatable
{
    /**
     * @inheritDoc
     * @return RoleDefinition
     */
    public function create(string $id) : RoleDefinition;
}