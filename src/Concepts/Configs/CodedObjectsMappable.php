<?php

namespace MagpieLib\Cerberus\Concepts\Configs;

use MagpieLib\Cerberus\Objects\BaseCodedObject;

/**
 * Map map coded objects
 */
interface CodedObjectsMappable
{
    /**
     * All objects in the map
     * @return iterable<BaseCodedObject>
     */
    public function getObjects() : iterable;


    /**
     * Find by given ID
     * @param string|null $id
     * @return BaseCodedObject|null
     */
    public function findById(?string $id) : ?BaseCodedObject;


    /**
     * Find by given code
     * @param string|null $code
     * @return BaseCodedObject|null
     */
    public function findByCode(?string $code) : ?BaseCodedObject;
}