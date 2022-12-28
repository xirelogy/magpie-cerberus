<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use Magpie\Cryptos\Algorithms\Hashes\CommonHasher;
use Magpie\General\Sugars\Excepts;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubjectGroup;

/**
 * Expanded subjects from specifications
 */
class ExpandedSubjects
{
    /**
     * @var array<string, CommonSubject> All subjects
     */
    public readonly array $subjects;


    /**
     * Constructor
     * @param iterable<CommonSubject|CommonSubjectGroup> $subjectSpecs
     */
    public function __construct(iterable $subjectSpecs)
    {
        $subjects = new Deduplicator();
        foreach ($subjectSpecs as $subjectSpec) {
            $subjects->feed($subjectSpec);
        }

        $this->subjects = $subjects->export();
    }


    /**
     * If there is subject in the list
     * @return bool
     */
    public final function hasSubject() : bool
    {
        return count($this->subjects) > 0;
    }


    /**
     * Calculate the equivalent hash
     * @return string
     */
    public final function calculateHash() : string
    {
        $plaintext = $this->onGetHashPlaintext();

        return Excepts::noThrow(fn () =>
            CommonHasher::sha1()->hashString($plaintext)->asLowerHex()
        , '');
    }


    /**
     * Compose the plaintext for hash calculation
     * @return string
     */
    protected function onGetHashPlaintext() : string
    {
        $ids = [];
        foreach ($this->subjects as $id => $subject) {
            $ids[] = $id;
        }

        sort($ids, SORT_STRING);

        return implode(';', $ids);
    }
}