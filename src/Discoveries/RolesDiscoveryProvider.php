<?php

namespace MagpieLib\Cerberus\Discoveries;

use Magpie\Exceptions\NotOfTypeException;
use Magpie\Exceptions\OperationFailedException;
use MagpieLib\Cerberus\Annotations\RoleEntry;
use MagpieLib\Cerberus\Annotations\RoleEntryRoot;
use MagpieLib\Cerberus\Annotations\RoleNamespace;
use MagpieLib\Cerberus\Annotations\RoleTenant;
use MagpieLib\Cerberus\Concepts\Configs\RolesProvidable;
use MagpieLib\Cerberus\Concepts\Definable;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredAttributes;
use MagpieLib\Cerberus\Discoveries\States\DiscoveredClassState;
use MagpieLib\Cerberus\Objects\Definitions\BaseRoleDefinitions;
use MagpieLib\Cerberus\Objects\Definitions\RoleDefinition;
use MagpieLib\Cerberus\Objects\Role;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

/**
 * Roles by reflection-discovery provider
 */
class RolesDiscoveryProvider extends BaseClassMethodDiscoveryProvider implements RolesProvidable
{
    /**
     * @inheritDoc
     */
    public final function getAllPreset() : iterable
    {
        try {
            yield from $this->discover();
        } catch (ReflectionException $ex) {
            throw new OperationFailedException(previous: $ex);
        }
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverClassState(ReflectionClass $class) : DiscoveredClassState
    {
        return parent::onDiscoverClassState($class)
            ->mergeSingle($class, RoleTenant::class)
            ;
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverClassMethodAttributes(ReflectionClass $class, ReflectionMethod $method) : DiscoveredAttributes
    {
        return parent::onDiscoverClassMethodAttributes($class, $method)
            ->mergeSingle($method, RoleEntryRoot::class)
            ;
    }


    /**
     * @inheritDoc
     */
    protected function onDiscoverFromClassMethod(ReflectionClass $class, Definable $classInst, ReflectionMethod $method, string $defNamespace, string $defName, DiscoveredClassState $classState, DiscoveredAttributes $methodAttributes) : Role
    {
        $code = static::makeFullName($defNamespace, $defName);

        $roleDefinition = $classInst->{$method->name}();
        if (!$roleDefinition instanceof RoleDefinition) throw new NotOfTypeException($roleDefinition, RoleDefinition::class);

        $this->updateDiscoveredDefinition($roleDefinition, $code, $classState, $methodAttributes);
        return $roleDefinition->createObject();
    }


    /**
     * @inheritDoc
     */
    protected static function getNamespaceBaseClass() : string
    {
        return BaseRoleDefinitions::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getNamespaceAttrClass() : string
    {
        return RoleNamespace::class;
    }


    /**
     * @inheritDoc
     */
    protected static function getEntryAttrClass() : string
    {
        return RoleEntry::class;
    }
}