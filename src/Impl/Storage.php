<?php

namespace MagpieLib\Cerberus\Impl;

use Exception;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Traits\SingletonInstance;
use Magpie\Models\Identifier;
use Magpie\System\Kernel\ExceptionHandler;

/**
 * Internal storage
 * @internal
 */
class Storage
{
    use SingletonInstance;

    /**
     * @var CodedObjectsMap Lookup map for roles
     */
    public readonly CodedObjectsMap $rolesMap;
    /**
     * @var CodedObjectsMap Lookup map for features
     */
    public readonly CodedObjectsMap $featuresMap;
    /**
     * @var array<string> IDs of default provided features
     */
    public readonly array $defaultProvidedFeatureIds;


    /**
     * Constructor
     * @param Config $config
     * @throws SafetyCommonException
     */
    protected function __construct(Config $config)
    {
        $this->rolesMap = new CodedObjectsMap(fn () => $config->glossaries->nameOfRole());
        $this->featuresMap = new CodedObjectsMap(fn () => $config->glossaries->nameOfFeature());

        // Process preset roles and features
        $defaultProvidedFeatureIds = [];
        foreach ($config->rolesProvider->getAllPreset() as $role) {
            $this->rolesMap->add($role);
        }
        foreach ($config->featuresProvider->getAllPreset() as $feature) {
            $this->featuresMap->add($feature);
            if ($feature->isDefaultProvided()) $defaultProvidedFeatureIds[] = Identifier::toString($feature->getId());
        }

        $this->defaultProvidedFeatureIds = $defaultProvidedFeatureIds;
    }


    /**
     * @inheritDoc
     */
    protected static function createInstance() : static
    {
        try {
            $config = Config::instance();
            return new static($config);
        } catch (Exception $ex) {
            ExceptionHandler::systemCritical($ex);
        }
    }
}