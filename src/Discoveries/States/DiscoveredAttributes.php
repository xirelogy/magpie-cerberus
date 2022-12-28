<?php

namespace MagpieLib\Cerberus\Discoveries\States;

use Magpie\General\Traits\StaticCreatable;
use MagpieLib\Cerberus\Concepts\Discoveries\AttributeMergeable;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * Discovered attributes
 */
class DiscoveredAttributes implements AttributeMergeable
{
    use StaticCreatable;

    /**
     * @var array<ReflectionAttribute> Discovered attributes
     */
    protected array $attributes = [];


    /**
     * All discovered attributes
     * @return iterable<ReflectionAttribute>
     */
    public function getAll() : iterable
    {
        yield from $this->attributes;
    }


    /**
     * @inheritDoc
     */
    public function mergeSingle(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName) : static
    {
        $this->merge($ref, $attrClassName, true);
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function mergeMultiple(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName) : static
    {
        $this->merge($ref, $attrClassName, false);
        return $this;
    }


    /**
     * Merge in instance(s) of given attribute
     * @param ReflectionClass|ReflectionMethod|ReflectionProperty $ref
     * @param string $attrClassName
     * @param bool $isSingle
     * @return void
     */
    private function merge(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName, bool $isSingle) : void
    {
        foreach ($ref->getAttributes($attrClassName) as $attribute) {
            $this->attributes[] = $attribute;
            if ($isSingle) break;
        }
    }
}