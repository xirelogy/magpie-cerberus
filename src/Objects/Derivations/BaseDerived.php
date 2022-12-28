<?php

namespace MagpieLib\Cerberus\Objects\Derivations;

use Magpie\General\Concepts\Identifiable;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubject;
use MagpieLib\Cerberus\Concepts\Objects\CommonSubjectGroup;

/**
 * Collection for derived items during expansion
 */
abstract class BaseDerived
{
    /**
     * @var Deduplicator Deduplicated result
     */
    protected readonly Deduplicator $results;
    /**
     * @var array<string, array<CommonSubject|CommonSubjectGroup>> Map of subject specs
     */
    protected array $resultSubjectSpecs = [];


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->results = new Deduplicator();
    }


    /**
     * Get subject specifications associated to given parent
     * @param Identifiable $parent
     * @return array<CommonSubjectGroup|CommonSubject>|null
     */
    protected final function getSubjectSpecsFor(Identifiable $parent) : ?array
    {
        $key = Deduplicator::makeKey($parent);
        return $this->resultSubjectSpecs[$key] ?? null;
    }


    /**
     * Merge subject specifications and associate it with given key
     * @param string $key
     * @param iterable<CommonSubjectGroup|CommonSubject> $subjectSpecs
     * @return void
     */
    protected final function mergeSubjectSpecs(string $key, iterable $subjectSpecs) : void
    {
        $specs = $this->resultSubjectSpecs[$key] ?? [];

        foreach ($subjectSpecs as $subjectSpec) {
            $specs[] = $subjectSpec;
        }

        $this->resultSubjectSpecs[$key] = $specs;
    }
}