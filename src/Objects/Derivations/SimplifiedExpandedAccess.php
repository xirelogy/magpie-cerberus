<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

/**
 * A simplified expanded access data for quick check and reference
 */
class SimplifiedExpandedAccess
{
    /**
     * @var array<string, SimplifiedFeatureAccess> List of accessible features with ID as key
     */
    public readonly array $features;
    /**
     * @var array<string, SimplifiedSubjectsAccess> List of accessible subjects, with hash as key
     */
    public readonly array $subjectLists;


    /**
     * Constructor
     * @param array<string, SimplifiedFeatureAccess> $features
     * @param array<string, SimplifiedSubjectsAccess> $subjectLists
     */
    public function __construct(array $features, array $subjectLists)
    {
        $this->features = $features;
        $this->subjectLists = $subjectLists;
    }
}