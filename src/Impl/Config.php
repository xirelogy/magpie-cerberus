<?php

namespace MagpieLib\Cerberus\Impl;

use Magpie\Exceptions\InvalidStateException;
use Magpie\Exceptions\SafetyCommonException;
use MagpieLib\Cerberus\Concepts\Caches\SimplifiedExpandedAccessCacheable;
use MagpieLib\Cerberus\Concepts\Configs\FeatureDefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Configs\FeaturesProvidable;
use MagpieLib\Cerberus\Concepts\Configs\Glossaries;
use MagpieLib\Cerberus\Concepts\Configs\RoleDefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Configs\RolesProvidable;
use MagpieLib\Cerberus\Objects\Strategies\AccessChecker;
use MagpieLib\Cerberus\Objects\Strategies\AccessExpander;

/**
 * Cerberus system configuration
 * @internal
 */
class Config
{
    /**
     * @var static|null Current instance
     */
    protected static ?self $instance = null;
    /**
     * @var Glossaries Glossaries
     */
    public readonly Glossaries $glossaries;
    /**
     * @var RolesProvidable Preset roles provider
     */
    public readonly RolesProvidable $rolesProvider;
    /**
     * @var FeaturesProvidable Preset features provider
     */
    public readonly FeaturesProvidable $featuresProvider;
    /**
     * @var RoleDefinitionCreatable RoleDefinition creator (factory)
     */
    public readonly RoleDefinitionCreatable $rolesFactory;
    /**
     * @var FeatureDefinitionCreatable FeatureDefinition creator (factory)
     */
    public readonly FeatureDefinitionCreatable $featuresFactory;
    /**
     * @var AccessExpander Access expander
     */
    public readonly AccessExpander $accessExpander;
    /**
     * @var AccessChecker Access checker
     */
    public readonly AccessChecker $accessChecker;
    /**
     * @var SimplifiedExpandedAccessCacheable|null SimplifiedExpandedAccess cache provider
     */
    public readonly ?SimplifiedExpandedAccessCacheable $simplifiedExpandedAccessCache;


    /**
     * Constructor
     * @param Glossaries $glossaries
     * @param RolesProvidable $rolesProvider
     * @param FeaturesProvidable $featuresProvider
     * @param RoleDefinitionCreatable $rolesFactory
     * @param FeatureDefinitionCreatable $featuresFactory
     * @param AccessExpander $accessExpander
     * @param AccessChecker $accessChecker
     * @param SimplifiedExpandedAccessCacheable|null $simplifiedExpandedAccessCache
     */
    public function __construct(
        Glossaries $glossaries,
        RolesProvidable $rolesProvider,
        FeaturesProvidable $featuresProvider,
        RoleDefinitionCreatable $rolesFactory,
        FeatureDefinitionCreatable $featuresFactory,
        AccessExpander $accessExpander,
        AccessChecker $accessChecker,
        ?SimplifiedExpandedAccessCacheable $simplifiedExpandedAccessCache,
    ) {
        $this->glossaries = $glossaries;
        $this->rolesProvider = $rolesProvider;
        $this->featuresProvider = $featuresProvider;
        $this->rolesFactory = $rolesFactory;
        $this->featuresFactory = $featuresFactory;
        $this->accessExpander = $accessExpander;
        $this->accessChecker = $accessChecker;
        $this->simplifiedExpandedAccessCache = $simplifiedExpandedAccessCache;
    }


    /**
     * Initialize using given instance
     * @param Config $instance
     * @return void
     */
    public static function init(self $instance) : void
    {
        static::$instance = $instance;
    }


    /**
     * Get current instance
     * @return static
     * @throws SafetyCommonException
     */
    public static function instance() : static
    {
        if (static::$instance === null) throw new InvalidStateException(_l('cerberus is not configured'));
        return static::$instance;
    }
}