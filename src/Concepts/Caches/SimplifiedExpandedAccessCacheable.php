<?php

namespace MagpieLib\Cerberus\Concepts\Caches;

use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Objects\CommonActor;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;
use MagpieLib\Cerberus\Objects\Derivations\SimplifiedExpandedAccess;

interface SimplifiedExpandedAccessCacheable
{
    /**
     * Load from cache
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @return SimplifiedExpandedAccess|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function loadCache(CommonActor $actor, ?CommonContext $context) : ?SimplifiedExpandedAccess;


    /**
     * Save into cache
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @param SimplifiedExpandedAccess $payload
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function saveCache(CommonActor $actor, ?CommonContext $context, SimplifiedExpandedAccess $payload) : void;


    /**
     * Invalidate the cache data
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function invalidateCache(CommonActor $actor, ?CommonContext $context) : void;
}