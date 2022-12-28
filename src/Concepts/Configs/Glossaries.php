<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

/**
 * Name for specific
 */
interface Glossaries
{
    /**
     * The name for 'role'
     * @return string
     */
    public function nameOfRole() : string;


    /**
     * The name for 'feature'
     * @return string
     */
    public function nameOfFeature() : string;
}