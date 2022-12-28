<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;

/**
 * Actor group: group of actors
 */
interface CommonActorGroup extends Identifiable, CommonGroup
{
    /**
     * @inheritDoc
     * @return iterable<CommonActor>
     */
    public function getMembers() : iterable;
}