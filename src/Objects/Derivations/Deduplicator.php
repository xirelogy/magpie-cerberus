<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use Magpie\General\Concepts\Identifiable;
use Magpie\Models\Identifier;
use MagpieLib\Cerberus\Concepts\Objects\CommonGroup;

/**
 * Processor to remove duplications
 */
class Deduplicator
{
    /**
     * @var array<string, Identifiable> Deduplicated items
     */
    protected array $items = [];


    /**
     * If target exist
     * @param Identifiable $target
     * @return bool
     */
    public function has(Identifiable $target) : bool
    {
        $key = static::makeKey($target);
        return array_key_exists($key, $this->items);
    }


    /**
     * List all entries in the result
     * @return iterable<Identifiable>
     */
    public function listAll() : iterable
    {
        foreach ($this->items as $result) {
            yield $result;
        }
    }


    /**
     * Export the items
     * @return array<string, Identifiable>
     */
    public function export() : array
    {
        return $this->items;
    }


    /**
     * Feed an item into the deduplicator, expanding groups accordingly
     * @param CommonGroup|Identifiable $spec
     * @return iterable<string>
     */
    public function feed(CommonGroup|Identifiable $spec) : iterable
    {
        if ($spec instanceof CommonGroup) {
            foreach ($spec->getMembers() as $member) {
                yield from $this->feed($member);
            }
        } else {
            yield $this->onMerge($spec);
        }
    }


    /**
     * Merge target into result
     * @param Identifiable $target
     * @return string
     */
    protected function onMerge(Identifiable $target) : string
    {
        $key = static::makeKey($target);
        if (!array_key_exists($key, $this->items)) {
            $this->items[$key] = $target;
        }

        return $key;
    }


    /**
     * Make item key
     * @param Identifiable $target
     * @return string
     */
    public static final function makeKey(Identifiable $target) : string
    {
        return Identifier::toString($target->getId());
    }
}