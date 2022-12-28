<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Specify that role/role entry must be associated with tenants
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
class RoleTenant
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }
}