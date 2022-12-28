<?php

namespace MagpieLib\Cerberus\Objects\Strategies;

use Magpie\Exceptions\GeneralPersistenceException;
use Magpie\Exceptions\NullException;
use Magpie\Exceptions\PersistenceException;
use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Objects\CommonActor;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;
use MagpieLib\Cerberus\Concepts\Objects\CommonRule;
use MagpieLib\Cerberus\Impl\Storage;
use MagpieLib\Cerberus\Objects\DefaultContext;
use MagpieLib\Cerberus\Objects\Derivations\ExpandedAccess;
use MagpieLib\Cerberus\Objects\Derivations\FeaturesDerivedFromRoles;
use MagpieLib\Cerberus\Objects\Derivations\RolesDerivedFromRules;
use MagpieLib\Cerberus\Objects\Feature;

/**
 * Expand effective access control information from access rules
 */
abstract class AccessExpander
{
    /**
     * Expand the access information for given actor
     * @param CommonActor $actor Target actor to be expanded upon
     * @param CommonContext|null $context Context to limit the expansion, if applicable
     * @return ExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    public final function expand(CommonActor $actor, ?CommonContext $context = null) : ExpandedAccess
    {
        $storage = Storage::instance();
        $context = $context ?? DefaultContext::instance();

        $state = $this->createState();
        $rules = [];

        // Derive roles from rules
        $derivedRoles = $this->createDerivedRoles();
        foreach ($this->getRules($actor, $context) as $rule) {
            $rules[] = $rule;
            $derivedRoles->feedRule($rule);
        }

        $this->onAfterDerivedRoles($state, $actor, $context, $derivedRoles);

        // Derive features
        $derivedFeatures = $this->createDerivedFeatures();
        foreach ($storage->defaultProvidedFeatureIds as $defaultProvidedFeatureId) {
            $feature = Feature::fromId($defaultProvidedFeatureId);
            if ($feature === null) continue;
            $derivedFeatures->feedFeature($feature);
        }

        foreach ($derivedRoles->getRoles() as $role) {
            $subjectSpecs = $derivedRoles->getRoleSubjectSpecs($role);
            $derivedFeatures->feedRole($role, $subjectSpecs);
        }

        $this->onAfterDerivedFeatures($state, $actor, $context, $derivedFeatures);

        // Pack the result
        return $this->createResult($rules, $derivedRoles, $derivedFeatures);
    }


    /**
     * Get all rules associated with given actor for given context
     * @param CommonActor $actor
     * @param CommonContext $context
     * @return iterable<CommonRule>
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected abstract function getRules(CommonActor $actor, CommonContext $context) : iterable;


    /**
     * Create a state for processing the access expansion
     * @return object
     */
    protected function createState() : object
    {
        return obj();
    }



    /**
     * Create derived-roles collection
     * @return RolesDerivedFromRules
     */
    protected function createDerivedRoles() : RolesDerivedFromRules
    {
        return new RolesDerivedFromRules();
    }


    /**
     * Post handling after roles derived
     * @param object $state
     * @param CommonActor $actor
     * @param CommonContext $context
     * @param RolesDerivedFromRules $derivedRoles
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected function onAfterDerivedRoles(object $state, CommonActor $actor, CommonContext $context, RolesDerivedFromRules $derivedRoles) : void
    {
        _used($state, $actor, $context, $derivedRoles);
        _throwable(1) ?? throw new NullException();
        _throwable(2) ?? throw new GeneralPersistenceException();
    }


    /**
     * Create derived-features collection
     * @return FeaturesDerivedFromRoles
     */
    protected function createDerivedFeatures() : FeaturesDerivedFromRoles
    {
        return new FeaturesDerivedFromRoles();
    }


    /**
     * Post handling after features derived
     * @param object $state
     * @param CommonActor $actor
     * @param CommonContext $context
     * @param FeaturesDerivedFromRoles $derivedFeatures
     * @return void
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected function onAfterDerivedFeatures(object $state, CommonActor $actor, CommonContext $context, FeaturesDerivedFromRoles $derivedFeatures) : void
    {
        _used($state, $actor, $context, $derivedFeatures);
        _throwable(1) ?? throw new NullException();
        _throwable(2) ?? throw new GeneralPersistenceException();
    }


    /**
     * Create the expanded result
     * @param array<CommonRule> $rules
     * @param RolesDerivedFromRules $derivedRoles
     * @param FeaturesDerivedFromRoles $derivedFeatures
     * @return ExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected function createResult(array $rules, RolesDerivedFromRules $derivedRoles, FeaturesDerivedFromRoles $derivedFeatures) : ExpandedAccess
    {
        $ret = $this->onCreateResult($rules, $derivedRoles, $derivedFeatures);

        // Apply subjects to features
        foreach ($ret->features as $feature) {
            $subjectSpecs = $derivedFeatures->getFeatureSubjectSpecs($feature);
            if ($subjectSpecs === null) continue;

            $ret->setSubjects($feature, $subjectSpecs);
        }

        return $this->onFinalizeResult($ret, $rules, $derivedRoles, $derivedFeatures);
    }


    /**
     * Create the result object
     * @param array<CommonRule> $rules
     * @param RolesDerivedFromRules $derivedRoles
     * @param FeaturesDerivedFromRoles $derivedFeatures
     * @return ExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected function onCreateResult(array $rules, RolesDerivedFromRules $derivedRoles, FeaturesDerivedFromRoles $derivedFeatures) : ExpandedAccess
    {
        _used($derivedRoles);
        _throwable(1) ?? throw new NullException();
        _throwable(2) ?? throw new GeneralPersistenceException();

        return new ExpandedAccess($rules, $derivedFeatures->getFeatures());
    }


    /**
     * Finalize the result
     * @param ExpandedAccess $ret
     * @param array<CommonRule> $rules
     * @param RolesDerivedFromRules $derivedRoles
     * @param FeaturesDerivedFromRoles $derivedFeatures
     * @return ExpandedAccess
     * @throws SafetyCommonException
     * @throws PersistenceException
     */
    protected function onFinalizeResult(ExpandedAccess $ret, array $rules, RolesDerivedFromRules $derivedRoles, FeaturesDerivedFromRoles $derivedFeatures) : ExpandedAccess
    {
        _used($rules, $derivedRoles, $derivedFeatures);
        _throwable(1) ?? throw new NullException();
        _throwable(2) ?? throw new GeneralPersistenceException();

        return $ret;
    }
}