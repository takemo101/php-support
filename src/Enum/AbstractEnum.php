<?php

namespace Takemo101\PHPSupport\Enum;

use ReflectionClass;
use BadMethodCallException;
use UnexpectedValueException;
use JsonSerializable;

/**
 * abstract enum class
 */
abstract class AbstractEnum implements JsonSerializable
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
     * Enumインスタンスの値を返す
     *
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Enumインスタンスの定数名を返す
     *
     * @return string
     */
    public function key()
    {
        return $this->key;
    }

    /**
     * Enumの値が一致するか
     *
     * @param mixed $enum
     * @return bool
     */
    public function equals($enum): bool
    {
        return $enum instanceof static
            && $this->value() === $enum->value();
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
     * serialize value.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->value;
    }

    /**
     * 全てのEnumの定数名を返す
     *
     * @return string[]
     */
    public static function keys(): array
    {
        return array_keys(static::asArray());
    }

    /**
     * 全てのEnumの値を返す
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_values(static::asArray());
    }

    /**
     * 全てのEnumインスタンスを返す
     *
     * @return static[]
     */
    public static function constants()
    {
        $values = [];

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    /**
     * Enumの値が定義した定数に含まれるかチェックして
     * 含まれた場合一致した定数名を返す
     *
     * @param mixed $value
     * @throws UnexpectedValueException
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
     * Enumの値が定義した定数に含まれるかを検索する
     * 含まれた場合は一致した定数名を返し
     * 一致しなかった場合はfalseを返す
     *
     * @param mixed $value
     * @return string|false
     */
    public static function search($value): string|bool
    {
        return array_search($value, static::asArray(), true);
    }

    /**
     * Enumの値が定義した定数に含まれるかの真偽値を返す
     *
     * @param mixed $enum
     * @return boolean
     */
    public static function in($value): bool
    {
        return in_array($value, static::asArray());
    }

    /**
     * 定数名 => 値 の配列を返す
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
