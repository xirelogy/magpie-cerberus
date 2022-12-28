<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Concepts\Packable;
use Magpie\General\Packs\PackContext;
use Magpie\General\Traits\CommonPackable;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonRule;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubjectGroup;

/**
 * Expanded access data
 */
class ExpandedAccess implements Packable
{
    use CommonPackable;

    /**
     * @var array<CommonRule> Expanded rules
     */
    public readonly array $rules;
    /**
     * @var array<CommonFeature> Expanded features
     */
    public readonly array $features;
    /**
     * @var array<string, string|null> Association map between feature and subjects (subject list)
     */
    protected array $featureSubjectsMap = [];
    /**
     * @var array<string, array<CommonSubject>> Deduplicated subject lists
     */
    protected array $subjectsLists = [];


    /**
     * Constructor
     * @param iterable<CommonRule> $rules
     * @param iterable<CommonFeature> $features
     */
    public function __construct(iterable $rules, iterable $features)
    {
        $this->rules = iter_flatten($rules, false);
        $this->features = iter_flatten($features, false);
    }


    /**
     * Simplify
     * @return SimplifiedExpandedAccess
     * @throws SafetyCommonException
     */
    public function simplify() : SimplifiedExpandedAccess
    {
        $retFeatures = $this->simplifyFeatures();
        $retSubjectsLists = $this->simplifySubjectsLists();

        return new SimplifiedExpandedAccess($retFeatures, $retSubjectsLists);
    }


    /**
     * Simplify the feature list
     * @return array<string, SimplifiedFeatureAccess>
     * @throws SafetyCommonException
     */
    protected function simplifyFeatures() : array
    {
        $ret = [];
        foreach ($this->features as $feature) {
            $featureKey = Deduplicator::makeKey($feature);
            $featureSubjectListHash = $this->featureSubjectsMap[$featureKey] ?? null;

            $ret[$featureKey] = new SimplifiedFeatureAccess($featureKey, $feature->getCode(), $featureSubjectListHash);
        }

        return $ret;
    }


    /**
     * Simplify the subjects lists
     * @return array<string, SimplifiedSubjectsAccess>
     */
    protected function simplifySubjectsLists() : array
    {
        $ret = [];
        foreach ($this->subjectsLists as $hash => $subjects) {
            $retSubjects = [];
            foreach ($subjects as $subject) {
                $retSubjects[] = Deduplicator::makeKey($subject);
            }

            $ret[$hash] = new SimplifiedSubjectsAccess($hash, $retSubjects);
        }

        return $ret;
    }


    /**
     * Get subject list for given feature
     * @param CommonFeature $feature
     * @return iterable<CommonSubject>
     */
    public function getSubjects(CommonFeature $feature) : iterable
    {
        $featureKey = Deduplicator::makeKey($feature);
        if (!array_key_exists($featureKey, $this->featureSubjectsMap)) return [];

        $subjectListHash = $this->featureSubjectsMap[$featureKey];
        if ($subjectListHash === null) return [];

        return $this->featureSubjectsMap[$subjectListHash] ?? [];
    }


    /**
     * Set the subject list for given feature
     * @param CommonFeature $feature
     * @param iterable<CommonSubject|CommonSubjectGroup> $subjectSpecs
     * @return void
     */
    public function setSubjects(CommonFeature $feature, iterable $subjectSpecs) : void
    {
        $expandedSubjects = new ExpandedSubjects($subjectSpecs);
        if (!$expandedSubjects->hasSubject()) return;

        $hash = $expandedSubjects->calculateHash();
        if (!array_key_exists($hash, $this->subjectsLists)) {
            $this->subjectsLists[$hash] = iter_flatten($expandedSubjects->subjects, false);
        }

        $featureKey = Deduplicator::makeKey($feature);
        $this->featureSubjectsMap[$featureKey] = $hash;
    }


    /**
     * @inheritDoc
     */
    protected function onPack(object $ret, PackContext $context) : void
    {
        $ret->rules = $this->rules;
        $ret->features = $this->features;
    }
}