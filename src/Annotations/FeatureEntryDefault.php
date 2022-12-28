<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Mark feature/feature entry as default provided
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class FeatureEntryDefault
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }
}