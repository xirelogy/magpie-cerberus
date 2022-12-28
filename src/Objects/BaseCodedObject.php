<?php

namespace MagpieLib\Cerberus\Objects;

use Magpie\General\Packs\PackContext;
use MagpieLib\Cerberus\Concepts\Codeable;
use MagpieLib\Cerberus\Concepts\Configs\CodedObjectsMappable;
use MagpieLib\Cerberus\Concepts\Describable;
use MagpieLib\Cerberus\Concepts\Objects\CommonContext;

/**
 * Base for cerberus related object which is coded (provides code)
 */
abstract class BaseCodedObject extends BaseObject implements Codeable, Describable
{
    /**
     * Check that current object is allowed in given context
     * @param CommonContext $context
     * @return bool
     */
    public final function isAllowedInContext(CommonContext $context) : bool
    {
        return $this->onCheckAllowedInContext($context);
    }


    /**
     * Check that current object is allowed in given context
     * @param CommonContext $context
     * @return bool
     */
    protected function onCheckAllowedInContext(CommonContext $context) : bool
    {
        _used($context);
        return true;
    }


    /**
     * @inheritDoc
     */
    protected function onPack(object $ret, PackContext $context) : void
    {
        parent::onPack($ret, $context);

        $ret->code = $this->getCode();
        $ret->desc = $this->getDesc();
    }


    /**
     * All items
     * @param CommonContext|null $context
     * @return iterable<static>
     */
    public static final function listAll(?CommonContext $context = null) : iterable
    {
        $context = $context ?? DefaultContext::instance();

        foreach (static::getMap()->getObjects() as $object) {
            if (!$object instanceof static) continue;
            if (!$object->isAllowedInContext($context)) continue;

            yield $object;
        }
    }


    /**
     * Get object instance from given ID
     * @param string|null $id
     * @return static|null
     */
    public static final function fromId(?string $id) : ?static
    {
        if ($id === null) return null;

        $object = static::getMap()->findById($id);
        if (!$object instanceof static) return null;

        return $object;
    }


    /**
     * Get object instance from given code
     * @param string|null $code
     * @return static|null
     */
    public static final function fromCode(?string $code) : ?static
    {
        if ($code === null) return null;

        $object = static::getMap()->findByCode($code);
        if (!$object instanceof static) return null;

        return $object;
    }


    /**
     * Get the storage map
     * @return CodedObjectsMappable
     */
    protected static abstract function getMap() : CodedObjectsMappable;
}