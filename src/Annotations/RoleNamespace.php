<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Assign role's namespace
 */
#[Attribute(Attribute::TARGET_CLASS)]
class RoleNamespace
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