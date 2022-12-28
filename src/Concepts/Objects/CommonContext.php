<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

/**
 * Context whereby access control is evaluated upon
 */
interface CommonContext
{
    /**
     * The tenant to be limited to, if applicable
     * @return CommonTenant|null
     */
    public function getLimitTenant() : ?CommonTenant;
}