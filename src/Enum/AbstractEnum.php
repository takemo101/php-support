<?php

namespace Takemo101\PHPSupport\Enum;

use ReflectionClass;
use BadMethodCallException;
use UnexpectedValueException;

/**
 * abstract enum class
 */
abstract class AbstractEnum
{
    /**
     * enum value
     *
     * @var mixed
     */
    protected $value;

    /**
     * enum key
     *
     * @var string
     */
    protected $key;

    /**
     * construct
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        if ($value instanceof static) {
            $value = $value->value();
        }

        $this->key = static::findCheckValueToKey($value);
        $this->value = $value;
    }

    /**
     * factory
     *
     * @param mixed $value
     * @return static
     */
    public static function of($value): self
    {
        $key = static::findCheckValueToKey($value);

        return self::__callStatic($key, []);
    }

    /**
     * enum value
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * enum key
     *
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * value to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string)$this->value();
    }

    /**
     * equals enum
     *
     * @param mixed $enum
     * @return bool
     */
    final public function equals($enum): bool
    {
        return $enum instanceof static
            && $this->value() === $enum->value();
    }

    /**
     * return all enum keys
     *
     * @return array<string>
     */
    public static function keys(): array
    {
        return array_keys(static::asArray());
    }

    /**
     * return all enum instances
     *
     * @return array<static>
     */
    public static function values(): array
    {
        $values = [];

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    /**
     * find and check value to key
     *
     * @param mixed $value
     * @return string
     */
    protected static function findCheckValueToKey($value): string
    {
        if (false === ($key = static::search($value))) {
            throw new UnexpectedValueException("[{$value}] is not part of the enum " . static::class);
        }

        return $key;
    }

    /**
     * search value to key
     *
     * @param mixed $value
     * @return string|boolean
     */
    public static function search($value): string|bool
    {
        return array_search($value, static::asArray(), true);
    }

    /**
     * return all enum array
     *
     * @return array
     */
    public static function asArray(): array
    {
        $class = static::class;
        $reflection = new ReflectionClass($class);
        return $reflection->getConstants();
    }

    /**
     * return enum instance
     *
     * @param string $name
     * @param array  $arguments
     * @throws BadMethodCallException
     * @return static
     */
    public static function __callStatic($name, $arguments)
    {
        $array = static::asArray();
        if (!isset($array[$name]) && !array_key_exists($name, $array)) {
            throw new BadMethodCallException(
                "no static method or enum constant '$name' in class " . static::class
            );
        }

        return new static($array[$name]);
    }
}
