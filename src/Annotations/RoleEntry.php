<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Assign role entry's name
 */
#[Attribute(Attribute::TARGET_METHOD)]
class RoleEntry
{
    /**
     * @var string Feature name
     */
    public readonly string $name;


    /**
     * Constructor
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }
}