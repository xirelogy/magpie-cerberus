<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;

/**
 * Role group: group of roles
 */
interface CommonRoleGroup extends Identifiable, CommonGroup
{
    /**
     * @inheritDoc
     * @return iterable<CommonRole>
     */
    public function getMembers() : iterable;
}