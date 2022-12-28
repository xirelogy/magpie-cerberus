<?php

namespace MagpieLib\Cerberus\Objects;

use Magpie\General\Packs\PackContext;
use MagpieLib\Cerberus\Concepts\Configs\CodedObjectsMappable;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonRole;
use MagpieLib\Cerberus\Impl\Storage;

/**
 * A role
 */
abstract class Role extends BaseCodedObject implements CommonRole
{
    /**
     * @inheritDoc
     */
    public final function getFeatures() : iterable
    {
        foreach ($this->onGetFeatures() as $feature) {
            $adaptedFeature = static::adaptFeature($feature);
            if ($adaptedFeature === null) continue;

            yield $adaptedFeature;
        }
    }


    /**
     * Get features provided by this role
     * @return iterable<CommonFeature>
     */
    protected abstract function onGetFeatures() : iterable;


    /**
     * @inheritDoc
     */
    public final function isNeedTenant() : bool
    {
        return $this->onIsNeedTenant();
    }


    /**
     * Check if tenant needed
     * @return bool
     */
    protected abstract function onIsNeedTenant() : bool;


    /**
     * @inheritDoc
     */
    public final function isRoot() : bool
    {
        return $this->onIsRoot();
    }


    /**
     * Check if this is a root role
     * @return bool
     */
    protected abstract function onIsRoot() : bool;


    /**
     * @inheritDoc
     */
    protected function onPack(object $ret, PackContext $context) : void
    {
        parent::onPack($ret, $context);

        if ($context->isLimitDepth('header')) return;

        if ($context->isUnreachableDepth('full')) return;

        $ret->features = $this->getFeatures();
    }


    /**
     * Adapt a feature
     * @param CommonFeature $feature
     * @return Feature|null
     */
    protected static function adaptFeature(CommonFeature $feature) : ?Feature
    {
        if ($feature instanceof Feature) return $feature;

        return Feature::fromId($feature->getId());
    }


    /**
     * @inheritDoc
     */
    protected static final function getMap() : CodedObjectsMappable
    {
        return Storage::instance()->rolesMap;
    }
}