<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Assign feature entry's name
 */
#[Attribute(Attribute::TARGET_METHOD)]
class FeatureEntry
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