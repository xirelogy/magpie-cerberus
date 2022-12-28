<?php

namespace MagpieLib\Cerberus\Annotations;

use Attribute;

/**
 * Mark role entry as root
 * (without tenant, system-wide root / with tenant, tenant root)
 */
#[Attribute(Attribute::TARGET_METHOD)]
class RoleEntryRoot
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }
}