<?php

namespace MagpieLib\Cerberus\Impl;

use Closure;
use Magpie\Exceptions\DuplicatedKeyException;
use Magpie\Exceptions\NullException;
use Magpie\Models\Identifier;
use MagpieLib\Cerberus\Concepts\Configs\CodedObjectsMappable;
use MagpieLib\Cerberus\Objects\BaseCodedObject;

/**
 * A lookup map for BaseCodedObject
 * @internal
 */
class CodedObjectsMap implements CodedObjectsMappable
{
    /**
     * @var Closure Function to provide object name
     */
    protected readonly Closure $objectNameFn;
    /**
     * @var array<string, BaseCodedObject> ID to object map
     */
    protected array $idMap = [];
    /**
     * @var array<string, BaseCodedObject> Code to object map
     */
    protected array $codeMap = [];


    /**
     * Constructor
     * @param callable():string $objectNameFn
     */
    public function __construct(callable $objectNameFn)
    {
        $this->objectNameFn = $objectNameFn;
    }


    /**
     * Add an object to the map
     * @param BaseCodedObject $object
     * @return void
     * @throws NullException
     * @throws DuplicatedKeyException
     */
    public function add(BaseCodedObject $object) : void
    {
        $id = Identifier::toString($object->getId());
        $code = $object->getCode();

        if (array_key_exists($id, $this->idMap)) throw new DuplicatedKeyException($id, $this->getObjectName());
        if (!is_empty_string($code) && array_key_exists($code, $this->codeMap)) throw new DuplicatedKeyException($code, $this->getObjectName());

        $this->idMap[$id] = $object;
        if (!is_empty_string($code)) $this->codeMap[$code] = $object;
    }


    /**
     * @inheritDoc
     */
    public function getObjects() : iterable
    {
        foreach ($this->idMap as $id => $object) {
            _used($id);
            yield $object;
        }
    }


    /**
     * @inheritDoc
     */
    public function findById(?string $id) : ?BaseCodedObject
    {
        if ($id === null) return null;
        return $this->idMap[$id] ?? null;
    }


    /**
     * @inheritDoc
     */
    public function findByCode(?string $code) : ?BaseCodedObject
    {
        if ($code === null) return null;
        return $this->codeMap[$code] ?? null;
    }


    /**
     * Object name
     * @return string
     */
    protected final function getObjectName() : string
    {
        return ($this->objectNameFn)();
    }
}