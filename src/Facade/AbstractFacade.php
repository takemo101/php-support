<?php

namespace Takemo101\PHPSupport\Facade;

use RuntimeException;
use Closure;

abstract class AbstractFacade
{
    /**
     * resolve instances
     *
     * @var object[]
     */
    protected static $instances = [];

    /**
     * self class facade binding
     *
     * @param Closure|string|null $callback
     * @return void
     */
    public static function binding(Closure|string|null $callback = null)
    {
        $label = static::accessor();

        if (is_object($label)) {
            return;
        }

        if (!Injector::has($label)) {
            Injector::singleton($label, $callback);
        }
    }

    /**
     * facade root object
     *
     * @return mixed
     */
    public static function root()
    {
        return static::resolveAccesser(static::accessor());
    }

    /**
     * facade accesser
     *
     * @throws RuntimeException
     * @return string|object
     */
    protected static function accessor(): string|object
    {
        throw new RuntimeException('does not implement accessor');
    }

    /**
     * resolve acesser instance
     *
     * @param object|string $name
     * @return mixed
     */
    protected static function resolveAccesser(object|string $label)
    {
        if (is_object($label)) {
            return $label;
        }

        // accesserのラベルでキャッシュをチェック
        if (isset(self::$instances[$label])) {
            return self::$instances[$label];
        }

        // バインディングされたインスタンスがなければシングルトンでバインドする
        if (!Injector::has($label)) {
            Injector::singleton($label);
        }

        $instance = Injector::make($label);
        self::$instances[$label] = $instance;
        return $instance;
    }

    /**
     * call accesser instance method
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     */
    public static function __callStatic($method, $parameters)
    {
        $instance = static::root();
        return $instance->$method(...$parameters);
    }
}
