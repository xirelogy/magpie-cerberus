<?php

namespace MagpieLib\Cerberus\Concepts;

use Magpie\Exceptions\NullException;

/**
 * May provide item code
 */
interface Codeable
{
    /**
     * Item code
     * @return string
     * @throws NullException
     */
    public function getCode() : string;
}