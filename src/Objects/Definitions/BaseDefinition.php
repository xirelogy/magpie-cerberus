<?php

namespace MagpieLib\Cerberus\Objects\Definitions;

use Magpie\Exceptions\NullException;
use Magpie\Exceptions\SafetyCommonException;
use Magpie\General\Concepts\Identifiable;
use MagpieLib\Cerberus\Concepts\Codeable;
use MagpieLib\Cerberus\Concepts\Configs\DefinitionCreatable;
use MagpieLib\Cerberus\Concepts\Definable;
use MagpieLib\Cerberus\Concepts\Describable;
use MagpieLib\Cerberus\Impl\StackCapture;
use MagpieLib\Cerberus\Objects\BaseCodedObject;
use ReflectionAttribute;

/**
 * Anything that can be defined by reflection
 */
abstract class BaseDefinition implements Identifiable, Codeable, Describable, Definable
{
    /**
     * @var string Associated ID
     */
    protected readonly string $id;
    /**
     * @var string|null Item code
     */
    protected ?string $code;
    /**
     * @var string Description
     */
    protected string $desc;


    /**
     * Constructor
     * @param string $id
     */
    protected function __construct(string $id)
    {
        $this->id = $id;
    }


    /**
     * @inheritDoc
     */
    public final function getId() : string
    {
        return $this->id;
    }


    /**
     * @inheritDoc
     */
    public final function getCode() : string
    {
        return $this->code ?? throw new NullException();
    }


    /**
     * Item code
     * @param string $code
     * @return $this
     */
    public final function setCode(string $code) : static
    {
        $this->code = $code;
        return $this;
    }


    /**
     * @inheritDoc
     */
    public final function getDesc() : string
    {
        return $this->desc;
    }


    /**
     * Description
     * @param string $desc
     * @return $this
     */
    public final function setDesc(string $desc) : static
    {
        $this->desc = $desc;
        return $this;
    }


    /**
     * Accept and process from given reflection attribute
     * @param ReflectionAttribute $attribute
     * @return $this
     * @throws SafetyCommonException
     */
    public final function acceptAttribute(ReflectionAttribute $attribute) : static
    {
        $this->onAcceptAttribute($attribute);
        return $this;
    }


    /**
     * Accepting and processing from given reflection attribute
     * @param ReflectionAttribute $attribute
     * @return void
     * @throws SafetyCommonException
     */
    protected function onAcceptAttribute(ReflectionAttribute $attribute) : void
    {
        _used($attribute);
        _throwable() ?? throw new NullException();
    }


    /**
     * Create the corresponding coded object for this definition
     * @return BaseCodedObject
     */
    public abstract function createObject() : BaseCodedObject;


    /**
     * @inheritDoc
     */
    public static final function define() : static
    {
        $id = StackCapture::generateId(static::getDefinitionClass());
        return static::getFactory()->create($id);
    }


    /**
     * Create a specific instance with given ID
     * @param string $id
     * @return static
     */
    public static function createInstanceWithId(string $id) : static
    {
        return new static($id);
    }


    /**
     * The class where all definitions of this kind is based upon
     * @return class-string
     */
    protected abstract static function getDefinitionClass() : string;


    /**
     * The factory to create instance of this kind
     * @return DefinitionCreatable
     * @throws SafetyCommonException
     */
    protected abstract static function getFactory() : DefinitionCreatable;
}