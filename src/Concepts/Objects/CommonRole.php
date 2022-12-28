<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;
use MagpieLib\Cerberus\Concepts\Codeable;

/**
 * Role: collection of multiple features in a way more understandable
 * for end users.
 */
interface CommonRole extends Identifiable, Codeable
{
    /**
     * Features provided by this role
     * @return iterable<CommonFeature>
     */
    public function getFeatures() : iterable;


    /**
     * If tenant needed
     * @return bool
     */
    public function isNeedTenant() : bool;


    /**
     * If this is a root role. When tenant is not needed,
     * this is a system-wide root role (wildcard role), and
     * when tenant is needed, this is the highest level role
     * in the tenant.
     * @return bool
     */
    public function isRoot() : bool;
}