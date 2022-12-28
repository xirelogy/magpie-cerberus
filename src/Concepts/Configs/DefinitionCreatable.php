<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use MagpieLib\Cerberus\Objects\Definitions\BaseDefinition;

/**
 * May create instance of definition for specific type (factory interface)
 */
interface DefinitionCreatable
{
    /**
     * Create a definition instance
     * @param string $id
     * @return BaseDefinition
     */
    public function create(string $id) : BaseDefinition;
}