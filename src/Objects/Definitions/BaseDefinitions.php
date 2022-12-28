<?php

namespace MagpieLib\Cerberus\Objects\Definitions;

use MagpieLib\Cerberus\Concepts\Definable;

/**
 * Collection class for everything definable by reflection
 */
abstract class BaseDefinitions implements Definable
{
    protected function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public static final function define() : static
    {
        return new static();
    }
}