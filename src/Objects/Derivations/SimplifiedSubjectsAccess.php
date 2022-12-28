<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

/**
 * A simplified list of accessible subjects (targets)
 */
class SimplifiedSubjectsAccess
{
    /**
     * @var string Associated list hash
     */
    public readonly string $hash;
    /**
     * @var array<string> Subject IDs
     */
    public readonly array $subjectIds;


    /**
     * Constructor
     * @param string $hash
     * @param array<string> $subjectIds
     */
    public function __construct(string $hash, array $subjectIds)
    {
        $this->hash = $hash;
        $this->subjectIds = $subjectIds;
    }
}