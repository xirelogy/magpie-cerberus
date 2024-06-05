<?php

namespace MagpieLib\Cerberus\Objects\Definitions;

use MagpieLib\Cerberus\Annotations\FeatureEntryDefault;
use MagpieLib\Cerberus\Concepts\Configs\DefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Impl\Config;
use MagpieLib\Cerberus\Objects\Adapters\FeatureByDefinition;
use MagpieLib\Cerberus\Objects\Feature;
use ReflectionAttribute;

/**
 * Feature definable by reflection
 */
class FeatureDefinition extends BaseDefinition implements CommonFeature
{
    /**
     * @var bool If default provided
     */
    protected bool $isDefaultProvided = false;


    /**
     * @inheritDoc
     */
    public function isDefaultProvided() : bool
    {
        return $this->isDefaultProvided;
    }


    /**
     * @inheritDoc
     */
    protected function onAcceptAttribute(ReflectionAttribute $attribute) : void
    {
        parent::onAcceptAttribute($attribute);

        switch ($attribute->getName()) {
            case FeatureEntryDefault::class:
                $this->isDefaultProvided = true;
                break;
            default:
                break;
        }
    }


    /**
     * @inheritDoc
     * @return Feature
     */
    public function createObject() : Feature
    {
        return new FeatureByDefinition($this);
    }


    /**
     * @inheritDoc
     */
    protected static function getDefinitionClass() : string
    {
        return BaseFeatureDefinitions::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getFactory() : DefinitionCreatable
    {
        return Config::instance()->featuresFactory;
    }
}