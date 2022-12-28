<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use MagpieLib\Cerberus\Objects\Definitions\FeatureDefinition;

/**
 * May create instance of feature definition
 */
interface FeatureDefinitionCreatable extends DefinitionCreatable
{
    /**
     * @inheritDoc
     * @return FeatureDefinition
     */
    public function create(string $id) : FeatureDefinition;
}