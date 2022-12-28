<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;

/**
 * Access control rule
 */
interface CommonRule
{
    /**
     * Associated tenant, if any
     * @return CommonTenant|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getTenantSpec() : ?CommonTenant;


    /**
     * Actor/actor group specification
     * @return CommonActor|CommonActorGroup
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getActorSpec() : CommonActor|CommonActorGroup;


    /**
     * Role/role group specification
     * @return CommonRole|CommonRoleGroup|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getRoleSpec() : CommonRole|CommonRoleGroup|null;


    /**
     * Subject/subject group specification
     * @return CommonSubject|CommonSubjectGroup|null
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function getSubjectSpec() : CommonSubject|CommonSubjectGroup|null;


    /**
     * List all rules associated to given actor
     * @param CommonActor $actor The associated actor
     * @param CommonContext|null $context Specific context to be further limited to, if any
     * @return iterable<static>
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public static function listByActor(CommonActor $actor, ?CommonContext $context = null) : iterable;
}