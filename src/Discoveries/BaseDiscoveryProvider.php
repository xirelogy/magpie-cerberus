<?php

namespace MagpieLib\Cerberus\Discoveries;

use Magpie\Exceptions\SafetyCommonException;
use Magpie\System\HardCore\AutoloadReflection;
use MagpieLib\Cerberus\Objects\BaseCodedObject;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Reflection-discovery based provider
 */
abstract class BaseDiscoveryProvider
{
    /**
     * @var string|array<string> Discovery specification
     */
    protected readonly string|array $spec;


    /**
     * Constructor
     * @param string|array<string> $spec
     */
    protected function __construct(string|array $spec)
    {
        $this->spec = $spec;
    }


    /**
     * Discover from given specification
     * @return iterable<BaseCodedObject>
     * @throws SafetyCommonException
     * @throws ReflectionException
     */
    protected final function discover() : iterable
    {
        $classes = AutoloadReflection::instance()->expandDiscoverySourcesReflection($this->spec);
        foreach ($classes as $class) {
            yield from $this->onDiscoverFromClass($class);
        }
    }


    /**
     * Discover from given class
     * @param ReflectionClass $class
     * @return iterable<BaseCodedObject>
     * @throws SafetyCommonException
     * @throws ReflectionException
     */
    protected abstract function onDiscoverFromClass(ReflectionClass $class) : iterable;


    /**
     * Make corresponding full name
     * @param string $namespace
     * @param string $name
     * @return string
     */
    protected static final function makeFullName(string $namespace, string $name) : string
    {
        return "$namespace/$name";
    }


    /**
     * Get a single attribute
     * @param ReflectionClass|ReflectionMethod|ReflectionProperty $ref
     * @param class-string $attrClassName
     * @return ReflectionAttribute|null
     */
    protected static final function getSingleAttribute(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName) : ?ReflectionAttribute
    {
        return iter_first($ref->getAttributes($attrClassName));
    }


    /**
     * Create an instance from given specification
     * @param string|array<string> $spec
     * @return static
     */
    public static function fromSpec(string|array $spec) : static
    {
        return new static($spec);
    }
}