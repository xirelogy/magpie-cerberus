<?php

namespace MagpieLib\Cerberus\Discoveries;

use Magpie\Exceptions\ClassNotOfTypeException;
use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Definable;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredAttributes;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredClassState;
use MagpieLib\Cerberus\Objects\BaseCodedObject;
use MagpieLib\Cerberus\Objects\Definitions\BaseDefinition;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Class-method reflection-discovery based provider
 */
abstract class BaseClassMethodDiscoveryProvider extends BaseDiscoveryProvider
{
    /**
     * @inheritDoc
     */
    protected final function onDiscoverFromClass(ReflectionClass $class) : iterable
    {
        $namespaceAttribute = static::getSingleAttribute($class, static::getNamespaceAttrClass());
        if ($namespaceAttribute === null) return;

        $expectedNamespaceBaseClass = static::getNamespaceBaseClass();
        if (!$class->isSubclassOf($expectedNamespaceBaseClass)) throw new ClassNotOfTypeException($class->name, $expectedNamespaceBaseClass);

        $namespaceAttributeInst = $namespaceAttribute->newInstance();
        $defNamespace = $namespaceAttributeInst->namespace;

        $className = $class->name;
        if (!is_subclass_of($className, Definable::class)) throw new ClassNotOfTypeException($className, Definable::class);

        $classInst = $className::define();
        $classState = $this->onDiscoverClassState($class);

        foreach ($class->getMethods() as $method) {
            $entryAttribute = static::getSingleAttribute($method, static::getEntryAttrClass());
            if ($entryAttribute === null) continue;

            $entryAttributeInst = $entryAttribute->newInstance();
            $defName = $entryAttributeInst->name;

            $methodAttributes = $this->onDiscoverClassMethodAttributes($class, $method);
            yield $this->onDiscoverFromClassMethod($class, $classInst, $method, $defNamespace, $defName, $classState, $methodAttributes);
        }
    }


    /**
     * Map class reflection discovered into corresponding class state
     * @param ReflectionClass $class
     * @return DiscoveredClassState
     */
    protected function onDiscoverClassState(ReflectionClass $class) : DiscoveredClassState
    {
        _used($class);

        return DiscoveredClassState::create();
    }


    /**
     * Map class method reflection discovered into corresponding attributes collection
     * @param ReflectionClass $class
     * @param ReflectionMethod $method
     * @return DiscoveredAttributes
     */
    protected function onDiscoverClassMethodAttributes(ReflectionClass $class, ReflectionMethod $method) : DiscoveredAttributes
    {
        _used($class, $method);

        return DiscoveredAttributes::create();
    }


    /**
     * @param ReflectionClass $class
     * @param Definable $classInst
     * @param ReflectionMethod $method
     * @param string $defNamespace
     * @param string $defName
     * @param DiscoveredClassState $classState
     * @param DiscoveredAttributes $methodAttributes
     * @return BaseCodedObject
     * @throws SafetyCommonException
     * @throws ReflectionException
     */
    protected abstract function onDiscoverFromClassMethod(ReflectionClass $class, Definable $classInst, ReflectionMethod $method, string $defNamespace, string $defName, DiscoveredClassState $classState, DiscoveredAttributes $methodAttributes) : BaseCodedObject;


    /**
     * Update the discovered attributes and information into the definition
     * @param BaseDefinition $definition
     * @param string $code
     * @param DiscoveredClassState $classState
     * @param DiscoveredAttributes $attributes
     * @return void
     * @throws SafetyCommonException
     */
    protected function updateDiscoveredDefinition(BaseDefinition $definition, string $code, DiscoveredClassState $classState, DiscoveredAttributes $attributes) : void
    {
        $definition->setCode($code);

        foreach ($classState->attributes->getAll() as $attribute) {
            $definition->acceptAttribute($attribute);
        }
        foreach ($attributes->getAll() as $attribute) {
            $definition->acceptAttribute($attribute);
        }
    }


    /**
     * The expected base class for namespace (definitions)
     * @return class-string
     */
    protected static abstract function getNamespaceBaseClass() : string;


    /**
     * The expected namespace attribute class-name
     * @return class-string
     */
    protected static abstract function getNamespaceAttrClass() : string;


    /**
     * The expected entry attribute class-name
     * @return class-string
     */
    protected static abstract function getEntryAttrClass() : string;
}