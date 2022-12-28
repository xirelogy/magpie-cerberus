<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Assign feature's namespace
 */
#[Attribute(Attribute::TARGET_CLASS)]
class FeatureNamespace
{
    /**
     * @var string Feature namespace
     */
    public readonly string $namespace;


    /**
     * Constructor
     * @param string $namespace
     */
    public function __construct(string $namespace)
    {
        $this->namespace = $namespace;
    }
}