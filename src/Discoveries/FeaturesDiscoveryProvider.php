<?php

namespace MagpieLib\Cerberus\Discoveries;

use Magpie\Exceptions\NotOfTypeException;
use Magpie\Exceptions\OperationFailedException;
use MagpieLib\Cerberus\Annotations\FeatureEntry;
use MagpieLib\Cerberus\Annotations\FeatureEntryDefault;
use MagpieLib\Cerberus\Annotations\FeatureNamespace;
use MagpieLib\Cerberus\Concepts\Configs\FeaturesProvidable;
use MagpieLib\Cerberus\Concepts\Definable;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredAttributes;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredClassState;
use MagpieLib\Cerberus\Objects\Definitions\BaseFeatureDefinitions;
use MagpieLib\Cerberus\Objects\Definitions\FeatureDefinition;
use MagpieLib\Cerberus\Objects\Feature;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Features by reflection-discovery provider
 */
class FeaturesDiscoveryProvider extends BaseClassMethodDiscoveryProvider implements FeaturesProvidable
{
    /**
     * @inheritDoc
     */
    public final function getAllPreset() : iterable
    {
        try {
            yield from $this->discover();
        } catch (ReflectionException $ex) {
            throw new OperationFailedException(previous: $ex);
        }
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverClassState(ReflectionClass $class) : DiscoveredClassState
    {
        return parent::onDiscoverClassState($class)
            ->mergeSingle($class, FeatureEntryDefault::class)
            ;
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverClassMethodAttributes(ReflectionClass $class, ReflectionMethod $method) : DiscoveredAttributes
    {
        return parent::onDiscoverClassMethodAttributes($class, $method)
            ->mergeSingle($method, FeatureEntryDefault::class)
            ;
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverFromClassMethod(ReflectionClass $class, Definable $classInst, ReflectionMethod $method, string $defNamespace, string $defName, DiscoveredClassState $classState, DiscoveredAttributes $methodAttributes) : Feature
    {
        $code = static::makeFullName($defNamespace, $defName);

        $featureDefinition = $classInst->{$method->name}();
        if (!$featureDefinition instanceof FeatureDefinition) throw new NotOfTypeException($featureDefinition, FeatureDefinition::class);

        $this->updateDiscoveredDefinition($featureDefinition, $code, $classState, $methodAttributes);
        return $featureDefinition->createObject();
    }


    /**
     * @inheritDoc
     */
    protected static function getNamespaceBaseClass() : string
    {
        return BaseFeatureDefinitions::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getNamespaceAttrClass() : string
    {
        return FeatureNamespace::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getEntryAttrClass() : string
    {
        return FeatureEntry::class;
    }
}