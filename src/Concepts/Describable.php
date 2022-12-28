<?php

namespace MagpieLib\Cerberus\Concepts;

/**
 * May provide description
 */
interface Describable
{
    /**
     * Description
     * @return string
     */
    public function getDesc() : string;
}