<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonRole;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubjectGroup;

/**
 * Features derived from roles
 */
class FeaturesDerivedFromRoles extends BaseDerived
{
    /**
     * If given feature exist
     * @param CommonFeature $feature
     * @return bool
     */
    public function hasFeature(CommonFeature $feature) : bool
    {
        return $this->results->has($feature);
    }


    /**
     * All items
     * @return iterable<CommonFeature>
     */
    public function getFeatures() : iterable
    {
        return $this->results->listAll();
    }


    /**
     * Get subject specifications associated to given feature
     * @param CommonFeature $feature
     * @return array<CommonSubjectGroup|CommonSubject>|null
     */
    public function getFeatureSubjectSpecs(CommonFeature $feature) : ?array
    {
        return $this->getSubjectSpecsFor($feature);
    }


    /**
     * Feed a role to be processed
     * @param CommonRole $role
     * @param array<CommonSubjectGroup|CommonSubject>|null $subjectSpecs
     * @return void
     */
    public function feedRole(CommonRole $role, ?array $subjectSpecs = null) : void
    {
        foreach ($role->getFeatures() as $feature) {
            $this->feedFeature($feature, $subjectSpecs);
        }
    }


    /**
     * Feed feature to be processed
     * @param CommonFeature $feature
     * @param array<CommonSubjectGroup|CommonSubject>|null $subjectSpecs
     * @return void
     */
    public function feedFeature(CommonFeature $feature, ?array $subjectSpecs = null) : void
    {
        foreach ($this->results->feed($feature) as $key) {
            if ($subjectSpecs !== null) $this->mergeSubjectSpecs($key, $subjectSpecs);
        }
    }
}