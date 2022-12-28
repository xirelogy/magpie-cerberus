<?php

namespace MagpieLib\Cerberus\Objects;

use Magpie\General\Traits\SingletonInstance;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;
use MagpieLib\Cerberus\Concepts\Objects\CommonTenant;

/**
 * Default context, with no limitation on tenant
 */
class DefaultContext implements CommonContext
{
    use SingletonInstance;


    /**
     * @inheritDoc
     */
    public function getLimitTenant() : ?CommonTenant
    {
        return null;
    }
}