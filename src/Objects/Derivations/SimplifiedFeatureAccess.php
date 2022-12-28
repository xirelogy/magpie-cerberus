<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

/**
 * Simplified accessible feature (with its subjects)
 */
class SimplifiedFeatureAccess
{
    /**
     * @var string Feature's ID
     */
    public readonly string $id;
    /**
     * @var string Feature's code
     */
    public readonly string $code;
    /**
     * @var string|null Hash of the accessible subjects (if available)
     */
    public readonly ?string $subjectsHash;


    /**
     * Constructor
     * @param string $id
     * @param string $code
     * @param string|null $subjectsHash
     */
    public function __construct(string $id, string $code, ?string $subjectsHash)
    {
        $this->id = $id;
        $this->code = $code;
        $this->subjectsHash = $subjectsHash;
    }
}