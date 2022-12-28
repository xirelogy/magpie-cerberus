<?php

namespace MagpieLib\Cerberus\Configs;

use MagpieLib\Cerberus\Concepts\Configs\FeatureDefinitionCreatable;
use MagpieLib\Cerberus\Objects\Definitions\FeatureDefinition;

/**
 * Default implementation of FeatureDefinitionCreatable
 */
class DefaultFeatureDefinitionCreator implements FeatureDefinitionCreatable
{
    /**
     * @inheritDoc
     */
    public function create(string $id) : FeatureDefinition
    {
        return FeatureDefinition::createInstanceWithId($id);
    }
}