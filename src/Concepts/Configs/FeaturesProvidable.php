<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;

/**
 * Provider for preset features
 */
interface FeaturesProvidable
{
    /**
     * All preset roles
     * @return iterable<CommonFeature>
     * @throws SafetyCommonException
     */
    public function getAllPreset() : iterable;
}