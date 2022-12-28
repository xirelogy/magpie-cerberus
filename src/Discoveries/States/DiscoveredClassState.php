<?php

namespace MagpieLib\Cerberus\Discoveries\States;

use Magpie\General\Traits\StaticCreatable;
use MagpieLib\Cerberus\Concepts\Discoveries\AttributeMergeable;
use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

class DiscoveredClassState implements AttributeMergeable
{
    use StaticCreatable;

    /**
     * @var DiscoveredAttributes Associated discovered attributes
     */
    public readonly DiscoveredAttributes $attributes;


    /**
     * Constructor
     */
    protected function __construct()
    {
        $this->attributes = DiscoveredAttributes::create();
    }


    /**
     * @inheritDoc
     */
    public function mergeSingle(ReflectionMethod|ReflectionClass|ReflectionProperty $ref, string $attrClassName) : static
    {
        $this->attributes->mergeSingle($ref, $attrClassName);
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function mergeMultiple(ReflectionMethod|ReflectionClass|ReflectionProperty $ref, string $attrClassName) : static
    {
        $this->attributes->mergeMultiple($ref, $attrClassName);
        return $this;
    }
}