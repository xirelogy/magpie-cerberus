<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;

/**
 * Subject group: group of subjects
 */
interface CommonSubjectGroup extends Identifiable, CommonGroup
{
    /**
     * @inheritDoc
     * @return iterable<CommonSubject>
     */
    public function getMembers() : iterable;
}