<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Objects\CommonRole;
use MagpieLib\Cerberus\Concepts\Objects\CommonRule;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubjectGroup;

/**
 * Roles derived from access control rules
 */
class RolesDerivedFromRules extends BaseDerived
{
    /**
     * All items
     * @return iterable<CommonRole>
     */
    public function getRoles() : iterable
    {
        return $this->results->listAll();
    }


    /**
     * Get subject specifications associated to given role
     * @param CommonRole $role
     * @return array<CommonSubjectGroup|CommonSubject>|null
     */
    public function getRoleSubjectSpecs(CommonRole $role) : ?array
    {
        return $this->getSubjectSpecsFor($role);
    }


    /**
     * Feed a rule for processing
     * @param CommonRule $rule
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public function feedRule(CommonRule $rule) : void
    {
        $roleSpec = $rule->getRoleSpec();
        if ($roleSpec === null) return;

        $subjectSpec = $rule->getSubjectSpec();

        foreach ($this->results->feed($roleSpec) as $key) {
            if ($subjectSpec !== null) $this->mergeSubjectSpecs($key, [$subjectSpec]);
        }
    }
}