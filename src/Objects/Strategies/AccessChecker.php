<?php

namespace MagpieLib\Cerberus\Objects\Strategies;

use Magpie\Exceptions\NullException;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\Models\Identifier;
use MagpieLib\Cerberus\Concepts\Objects\CommonActor;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Objects\Derivations\SimplifiedExpandedAccess;

/**
 * Access control check implementation
 */
class AccessChecker
{
    /**
     * Check that given actor/context has specific feature access to given target subject
     * @param SimplifiedExpandedAccess $expandedAccess
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @param array<CommonFeature>|CommonFeature|null $featureSpec
     * @param CommonSubject|null $targetSpec
     * @return bool
     * @throws SafetyCommonException
     */
    public final function checkAccess(SimplifiedExpandedAccess $expandedAccess, CommonActor $actor, ?CommonContext $context, array|CommonFeature|null $featureSpec, CommonSubject|null $targetSpec) : bool
    {
        // No feature specified: use default check
        if ($featureSpec === null) return $this->onCheckDefaultAccess($expandedAccess, $actor, $context, $targetSpec);

        // Check on the feature level
        if (!$this->hasFeatureAccess($expandedAccess, $featureSpec)) return false;

        // Check subjects
        $subjectId = static::acceptTargetAsSubjectId($targetSpec);
        if ($subjectId === null) return true;

        $subjectId = Identifier::toString($subjectId);
        if (!$this->hasSubjectAccess($expandedAccess, $featureSpec, $subjectId)) return false;

        return true;
    }


    /**
     * Check that the feature access is granted per the expanded accessible list
     * @param SimplifiedExpandedAccess $expandedAccess
     * @param array<CommonFeature>|CommonFeature $featureSpec
     * @return bool
     * @throws SafetyCommonException
     */
    protected function hasFeatureAccess(SimplifiedExpandedAccess $expandedAccess, array|CommonFeature $featureSpec) : bool
    {
        _throwable() ?? throw new NullException();

        foreach ($this->getFeatureIds($featureSpec) as $featureId) {
            if (array_key_exists($featureId, $expandedAccess->features)) return true;
        }

        return false;
    }


    /**
     * Check that the subject access is granted per the expanded accessible list
     * @param SimplifiedExpandedAccess $expandedAccess
     * @param array<CommonFeature>|CommonFeature $featureSpec
     * @param string $subjectId
     * @return bool
     * @throws SafetyCommonException
     */
    protected function hasSubjectAccess(SimplifiedExpandedAccess $expandedAccess, array|CommonFeature $featureSpec, string $subjectId) : bool
    {
        _throwable() ?? throw new NullException();

        foreach ($this->getFeatureIds($featureSpec) as $featureId) {
            $featureSubjectHash = $expandedAccess->features[$featureId]?->subjectsHash;
            if ($featureSubjectHash === null) continue;

            $subjectList = $expandedAccess->subjectLists[$featureSubjectHash] ?? null;
            if ($subjectList === null) continue;

            if (array_key_exists($subjectId, $subjectList->subjectIds)) return true;
        }

        return false;
    }


    /**
     * Convert feature specification into list of feature IDs
     * @param array<CommonFeature>|CommonFeature $featureSpec
     * @return array<string>
     */
    protected function getFeatureIds(array|CommonFeature $featureSpec) : array
    {
        $ret = [];
        foreach (static::acceptFeatures($featureSpec) as $feature) {
            $featureId = Identifier::toString($feature->getId());
            $ret[$featureId] = $featureId;
        }

        return array_values($ret);
    }


    /**
     * Check that given actor/context has default access to given target subject
     * @param SimplifiedExpandedAccess $expandedAccess
     * @param CommonActor $actor
     * @param CommonContext|null $context
     * @param CommonSubject|null $targetSpec
     * @return bool
     * @throws SafetyCommonException
     */
    protected function onCheckDefaultAccess(SimplifiedExpandedAccess $expandedAccess, CommonActor $actor, ?CommonContext $context, CommonSubject|null $targetSpec) : bool
    {
        _used($expandedAccess, $actor, $context, $targetSpec);
        _throwable() ?? throw new NullException();

        return true;
    }


    /**
     * Accept features
     * @param array<CommonFeature>|CommonFeature $featureSpec
     * @return iterable<CommonFeature>
     */
    protected static final function acceptFeatures(array|CommonFeature $featureSpec) : iterable
    {
        if (is_array($featureSpec)) {
            foreach ($featureSpec as $feature) {
                yield $feature;
            }
        } else if ($featureSpec instanceof CommonFeature) {
            yield $featureSpec;
        }
    }


    /**
     * Accept target
     * @param CommonSubject|null $targetSpec
     * @return Identifier|string|int|null
     */
    protected static final function acceptTargetAsSubjectId(CommonSubject|null $targetSpec) : Identifier|string|int|null
    {
        return $targetSpec?->getId();
    }
}