<?php

namespace MagpieLib\Cerberus\Objects\Definitions;

use MagpieLib\Cerberus\Annotations\RoleEntryRoot;
use MagpieLib\Cerberus\Annotations\RoleTenant;
use MagpieLib\Cerberus\Concepts\Configs\DefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Objects\CommonFeature;
use MagpieLib\Cerberus\Concepts\Objects\CommonRole;
use MagpieLib\Cerberus\Impl\Config;
use MagpieLib\Cerberus\Impl\Storage;
use MagpieLib\Cerberus\Objects\Adapters\RoleByDefinition;
use MagpieLib\Cerberus\Objects\Role;
use ReflectionAttribute;

/**
 * Role definable by reflection
 */
class RoleDefinition extends BaseDefinition implements CommonRole
{
    /**
     * @var array<CommonFeature> Associated features
     */
    protected array $features = [];
    /**
     * @var bool If tenant needed
     */
    protected bool $isNeedTenant = false;
    /**
     * @var bool If this is root
     */
    protected bool $isRoot = false;


    /**
     * @inheritDoc
     */
    public function getFeatures() : iterable
    {
        if (!$this->isNeedTenant && $this->isRoot) {
            // System wide root
            yield from Storage::instance()->featuresMap->getObjects();
            return;
        }

        yield from $this->features;
    }


    /**
     * Add a feature provided by this role
     * @param CommonFeature $feature
     * @return $this
     */
    public function addFeature(CommonFeature $feature) : static
    {
        $this->features[] = $feature;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public function isNeedTenant() : bool
    {
        return $this->isNeedTenant;
    }


    /**
     * @inheritDoc
     */
    public function isRoot() : bool
    {
        return $this->isRoot;
    }


    /**
     * @inheritDoc
     */
    protected function onAcceptAttribute(ReflectionAttribute $attribute) : void
    {
        parent::onAcceptAttribute($attribute);

        switch ($attribute->getName()) {
            case RoleTenant::class:
                $this->isNeedTenant = true;
                break;
            case RoleEntryRoot::class:
                $this->isRoot = true;
                break;
            default:
                break;
        }
    }


    /**
     * @inheritDoc
     * @return Role
     */
    public function createObject() : Role
    {
        return new RoleByDefinition($this);
    }


    /**
     * @inheritDoc
     */
    protected static function getDefinitionClass() : string
    {
        return BaseRoleDefinitions::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getFactory() : DefinitionCreatable
    {
        return Config::instance()->rolesFactory;
    }
}