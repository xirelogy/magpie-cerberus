<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Objects\CommonRole;

/**
 * Provider for preset roles
 */
interface RolesProvidable
{
    /**
     * All preset roles
     * @return iterable<CommonRole>
     * @throws SafetyCommonException
     */
    public function getAllPreset() : iterable;
}