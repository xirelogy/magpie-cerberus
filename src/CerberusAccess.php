<?php

namespace MagpieLib\Cerberus;

use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Traits\StaticClass;
use MagpieLib\Cerberus\Concepts\Objects\CommonActor;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonSession;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Impl\Config;
use MagpieLib\Cerberus\Objects\Derivations\ExpandedAccess;
use MagpieLib\Cerberus\Objects\Derivations\SimplifiedExpandedAccess;

/**
 * Cerberus access control check
 */
class CerberusAccess
{
    use StaticClass;


    /**
     * Check if the given accessor has the permission to access the feature (with given target)
     * @param CommonSession|CommonActor $accessor
     * @param array<CommonFeature>|CommonFeature|null $featureSpec
     * @param CommonSubject|null $targetSpec
     * @return bool
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public static function hasAccess(CommonSession|CommonActor $accessor, array|CommonFeature|null $featureSpec, CommonSubject|null $targetSpec) : bool
    {
        $actor = static::acceptAccessorActor($accessor);
        $context = static::acceptAccessorContext($accessor);

        $expandedAccess = static::expandSimplifiedAccess($actor, $context);

        return Config::instance()->accessChecker->checkAccess($expandedAccess, $actor, $context, $featureSpec, $targetSpec);
    }


    /**
     * Expand the effective granted access information for given actor and context
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @return ExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public static function expandAccess(CommonActor $actor, ?CommonContext $context = null) : ExpandedAccess
    {
        return Config::instance()->accessExpander->expand($actor, $context);
    }


    /**
     * Expand the effective granted access information for given actor and context, only
     * requiring the simplified information
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @return SimplifiedExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public static function expandSimplifiedAccess(CommonActor $actor, ?CommonContext $context = null) : SimplifiedExpandedAccess
    {
        $cache = Config::instance()->simplifiedExpandedAccessCache;

        $cached = $cache?->loadCache($actor, $context);
        if ($cached !== null) return $cached;

        $ret = static::expandAccess($actor, $context)->simplify();
        $cache?->saveCache($actor, $context, $ret);

        return $ret;
    }


    /**
     * Invalidate the effective granted access information cached for given actor and context
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public static function invalidateSimplifiedAccess(CommonActor $actor, ?CommonContext $context = null) : void
    {
        $cache = Config::instance()->simplifiedExpandedAccessCache;
        $cache?->invalidateCache($actor, $context);
    }


    /**
     * Accept accessor into corresponding actor
     * @param CommonSession|CommonActor $accessor
     * @return CommonActor
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected static function acceptAccessorActor(CommonSession|CommonActor $accessor) : CommonActor
    {
        if ($accessor instanceof CommonActor) return $accessor;

        return $accessor->getActor();
    }


    /**
     * Accept accessor into corresponding context
     * @param CommonSession|CommonActor $accessor
     * @return CommonContext|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected static function acceptAccessorContext(CommonSession|CommonActor $accessor) : ?CommonContext
    {
        if ($accessor instanceof CommonActor) return null;

        return $accessor->getContext();
    }
}