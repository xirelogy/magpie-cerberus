<?php

namespace MagpieLib\Cerberus\Objects\Supports;

use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;

/**
 * Read/write access control specification
 */
class ReadWriteAccessControlSpec
{
    /**
     * @var array<CommonFeature>|CommonFeature|null Required feature specification for read access (any)
     */
    public readonly array|CommonFeature|null $readFeatureSpec;
    /**
     * @var array<CommonFeature>|CommonFeature|null Required feature specification for write access (any)
     */
    public readonly array|CommonFeature|null $writeFeatureSpec;


    /**
     * Constructor
     * @param array<CommonFeature>|CommonFeature|null $readFeatureSpec
     * @param array<CommonFeature>|CommonFeature|null $writeFeatureSpec
     */
    public function __construct(array|CommonFeature|null $readFeatureSpec, array|CommonFeature|null $writeFeatureSpec)
    {
        $this->readFeatureSpec = $readFeatureSpec;
        $this->writeFeatureSpec = $writeFeatureSpec;
    }
}