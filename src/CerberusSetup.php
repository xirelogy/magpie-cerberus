<?php

namespace MagpieLib\Cerberus;

use Magpie\System\Concepts\SystemBootable;
use Magpie\System\Kernel\BootContext;
use Magpie\System\Kernel\BootRegistrar;
use MagpieLib\Cerberus\Concepts\Caches\SimplifiedExpandedAccessCacheable;
use MagpieLib\Cerberus\Concepts\Configs\FeatureDefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Configs\FeaturesProvidable;
use MagpieLib\Cerberus\Concepts\Configs\Glossaries;
use MagpieLib\Cerberus\Concepts\Configs\RoleDefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Configs\RolesProvidable;
use MagpieLib\Cerberus\Configs\DefaultFeatureDefinitionCreator;
use MagpieLib\Cerberus\Configs\DefaultGlossaries;
use MagpieLib\Cerberus\Configs\DefaultRoleDefinitionCreator;
use MagpieLib\Cerberus\Impl\Config;
use MagpieLib\Cerberus\Objects\Strategies\AccessChecker;
use MagpieLib\Cerberus\Objects\Strategies\AccessExpander;

/**
 * Service interface to set up the cerberus system
 */
abstract class CerberusSetup implements SystemBootable
{
    /**
     * @inheritDoc
     */
    public static final function systemBootRegister(BootRegistrar $registrar) : bool
    {
        return true;
    }


    /**
     * Configure the glossaries provider
     * @return Glossaries
     */
    protected static function setupGlossaries() : Glossaries
    {
        return new DefaultGlossaries();
    }


    /**
     * Configure the roles provider
     * @return RolesProvidable
     */
    protected static abstract function setupRolesProvider() : RolesProvidable;


    /**
     * Configure the features provider
     * @return FeaturesProvidable
     */
    protected static abstract function setupFeaturesProvider() : FeaturesProvidable;


    /**
     * Configure the RoleDefinition factory
     * @return RoleDefinitionCreatable
     */
    protected static function setupRoleDefinitionCreator() : RoleDefinitionCreatable
    {
        return new DefaultRoleDefinitionCreator();
    }


    /**
     * Configure the FeatureDefinition factory
     * @return FeatureDefinitionCreatable
     */
    protected static function setupFeatureDefinitionCreator() : FeatureDefinitionCreatable
    {
        return new DefaultFeatureDefinitionCreator();
    }


    /**
     * Configure the AccessExpander
     * @return AccessExpander
     */
    protected static abstract function setupAccessExpander() : AccessExpander;


    /**
     * Configure the AccessChecker
     * @return AccessChecker
     */
    protected static function setupAccessChecker() : AccessChecker
    {
        return new AccessChecker();
    }


    /**
     * Configure SimplifiedExpandedAccess cache provider
     * @return SimplifiedExpandedAccessCacheable|null
     */
    protected static function setupSimplifiedExpandedAccessCache() : ?SimplifiedExpandedAccessCacheable
    {
        return null;
    }


    /**
     * @inheritDoc
     */
    public static final function systemBoot(BootContext $context) : void
    {
        $config = new Config(
            static::setupGlossaries(),
            static::setupRolesProvider(),
            static::setupFeaturesProvider(),
            static::setupRoleDefinitionCreator(),
            static::setupFeatureDefinitionCreator(),
            static::setupAccessExpander(),
            static::setupAccessChecker(),
            static::setupSimplifiedExpandedAccessCache(),
        );

        Config::init($config);
    }
}