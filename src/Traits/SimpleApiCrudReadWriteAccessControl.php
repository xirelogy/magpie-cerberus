<?php

namespace MagpieLib\Cerberus\Traits;

use Magpie\Controllers\Strategies\ApiCrudPurpose;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\Exceptions\UnsupportedValueException;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Objects\Supports\ReadWriteAccessControlSpec;

/**
 * A simple trait to provide simple read-write access control for CRUD based REST controllers
 */
trait SimpleApiCrudReadWriteAccessControl
{
    /**
     * Get access control for given purpose
     * @param ApiCrudPurpose $purpose
     * @return array<CommonFeature>|CommonFeature|null
     * @throws SafetyCommonException
     */
    protected function onGetPurposeAccessControl(ApiCrudPurpose $purpose) : array|CommonFeature|null
    {
        $rwFeatures = $this->onGetReadWriteAccessControl();

        return match ($purpose) {
            ApiCrudPurpose::READ,
                => $rwFeatures->readFeatureSpec,
            ApiCrudPurpose::EDIT,
            ApiCrudPurpose::CREATE,
            ApiCrudPurpose::DELETE,
                => $rwFeatures->writeFeatureSpec,
            default,
                => throw new UnsupportedValueException($purpose),
        };
    }


    /**
     * Get access control in simple read/write form
     * @return ReadWriteAccessControlSpec
     * @throws SafetyCommonException
     */
    protected abstract function onGetReadWriteAccessControl() : ReadWriteAccessControlSpec;
}
