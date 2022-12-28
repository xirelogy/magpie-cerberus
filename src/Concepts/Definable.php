<?php

namespace MagpieLib\Cerberus\Concepts;

use Magpie\Exceptions\SafetyCommonException;

/**
 * Anything that can be 'defined' into definition/definitions
 */
interface Definable
{
    /**
     * Define an instance
     * @return static
     * @throws SafetyCommonException
     */
    public static function define() : static;
}