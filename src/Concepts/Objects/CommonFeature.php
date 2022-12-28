<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;
use MagpieLib\Cerberus\Concepts\Codeable;

/**
 * Feature: the smallest unit of access control, representing a feature
 * that user might use, or an action that user might take
 */
interface CommonFeature extends Identifiable, Codeable
{
    /**
     * If this feature is provided by default
     * @return bool
     */
    public function isDefaultProvided() : bool;
}