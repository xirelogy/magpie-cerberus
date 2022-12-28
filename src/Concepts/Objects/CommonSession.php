<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;

/**
 * Session: representation of an authentication and authorized user
 * trust to the system, normally limited to a temporary time and will
 * be revoked upon expiry or inactivity after certain time.
 */
interface CommonSession
{
    /**
     * Associated actor ('user')
     * @return CommonActor
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getActor() : CommonActor;


    /**
     * Associated context (if any)
     * @return CommonContext|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getContext() : ?CommonContext;
}