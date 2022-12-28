<?php

namespace MagpieLib\Cerberus\Configs;

use MagpieLib\Cerberus\Concepts\Configs\Glossaries;

/**
 * Default glossaries provider
 */
class DefaultGlossaries implements Glossaries
{
    /**
     * @inheritDoc
     */
    public function nameOfRole() : string
    {
        return _l('role');
    }


    /**
     * @inheritDoc
     */
    public function nameOfFeature() : string
    {
        return _l('feature');
    }
}