<?php

namespace MagpieLib\Cerberus\Objects;

use MagpieLib\Cerberus\Concepts\Configs\CodedObjectsMappable;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Impl\Storage;

/**
 * A feature
 */
abstract class Feature extends BaseCodedObject implements CommonFeature
{
    /**
     * @inheritDoc
     */
    public final function isDefaultProvided() : bool
    {
        return $this->onIsDefaultProvided();
    }


    /**
     * Check if this feature is provided by default
     * @return bool
     */
    protected abstract function onIsDefaultProvided() : bool;


    /**
     * @inheritDoc
     */
    protected static final function getMap() : CodedObjectsMappable
    {
        return Storage::instance()->featuresMap;
    }
}