<?php

namespace MagpieLib\Cerberus\Objects;

use Magpie\General\Concepts\Identifiable;
use Magpie\General\Packs\PackContext;
use Magpie\Objects\CommonObject;

/**
 * Base for cerberus related objects
 */
abstract class BaseObject extends CommonObject implements Identifiable
{
    /**
     * @inheritDoc
     */
    protected function onPack(object $ret, PackContext $context) : void
    {
        parent::onPack($ret, $context);

        $ret->id = $this->getId();
    }
}