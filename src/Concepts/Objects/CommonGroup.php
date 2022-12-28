<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;

/**
 * Group items together
 */
interface CommonGroup
{
    /**
     * Members of the group
     * @return iterable<Identifiable>
     */
    public function getMembers() : iterable;
}