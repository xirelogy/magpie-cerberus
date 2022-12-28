<?php

namespace MagpieLib\Cerberus\Concepts\Objects;

use Magpie\General\Concepts\Identifiable;

/**
 * Actor: anyone that can perform operation on the system, which access control
 * is to be applied on. Generally correspond to system's user.
 */
interface CommonActor extends Identifiable
{

}