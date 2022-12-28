<?php

namespace MagpieLib\Cerberus\Objects\Adapters;

use MagpieLib\Cerberus\Objects\Definitions\FeatureDefinition;
use MagpieLib\Cerberus\Objects\Feature;
use MagpieLib\Cerberus\Objects\Traits\ForwardFromDefinition;

/**
 * Adapt FeatureDefinition into a Feature
 */
class FeatureByDefinition extends Feature
{
    use ForwardFromDefinition;


    /**
     * @var FeatureDefinition Associated definition
     */
    protected readonly FeatureDefinition $def;


    /**
     * Constructor
     * @param FeatureDefinition $def
     */
    public function __construct(FeatureDefinition $def)
    {
        $this->def = $def;
    }


    /**
     * @inheritDoc
     */
    protected function onIsDefaultProvided() : bool
    {
        return $this->getDefinition()->isDefaultProvided();
    }


    /**
     * @inheritDoc
     */
    protected function getDefinition() : FeatureDefinition
    {
        return $this->def;
    }
}