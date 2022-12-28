<?php

namespace MagpieLib\Cerberus\Concepts\Discoveries;

use ReflectionClass;
use ReflectionMethod;
use ReflectionProperty;

/**
 * May merge in attributes
 */
interface AttributeMergeable
{
    /**
     * Merge in single instance of given attribute
     * @param ReflectionClass|ReflectionMethod|ReflectionProperty $ref
     * @param string $attrClassName
     * @return $this
     */
    public function mergeSingle(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName) : static;


    /**
     * Merge in multiple instance of given attribute
     * @param ReflectionClass|ReflectionMethod|ReflectionProperty $ref
     * @param string $attrClassName
     * @return $this
     */
    public function mergeMultiple(ReflectionClass|ReflectionMethod|ReflectionProperty $ref, string $attrClassName) : static;
}