<?php

namespace Takemo101\PHPSupport\Facade;

use Closure;
use Takemo101\PHPSupport\Contract\Facade\Container as Contract;

/**
 * facade injector class
 */
final class Injector
{
    /**
     * container
     *
     * @var Contract|null
     */
    protected static $container = null;

    /**
     * シングルトンインスタンスをセットする
     *
     * @param Container $container
     * @return void
     */
    public static function setContainer(Contract $container)
    {
        self::$container = $container;
    }

    /**
     * singleton instance
     *
     * @return Contract
     */
    public static function instance(): Contract
    {
        if (!self::$container) {
            self::$container = new Container;
        }

        return self::$container;
    }

    /**
     * 別名の設定
     *
     * @param string $class
     * @param string $alias
     * @return Contract
     */
    public static function alias(string $class, string $alias)
    {
        return self::instance()->alias($class, $alias);
    }

    /**
     * シングルトンでの依存注入を設定
     *
     * @param string $label
     * @param Closure|string|null $callback
     * @return Contract
     */
    public static function singleton(string $label, Closure|string|null $callback = null)
    {
        return self::instance()->singleton($label, $callback);
    }

    /**
     * 通常の依存注入を設定
     *
     * @param string $label
     * @param Closure|string|null $callback
     * @return Contract
     */
    public static function bind(string $label, Closure|string|null $callback = null)
    {
        return self::instance()->bind($label, $callback);
    }

    /**
     * バインドされているか
     *
     * @param string $label
     * @return boolean
     */
    public static function has(string $label): bool
    {
        return self::instance()->has($label);
    }

    /**
     * 全てのバインディングを開放
     *
     * @return Contract
     */
    public static function clear()
    {
        return self::instance()->clear();
    }

    /**
     * クラスまたはラベル名から依存性を解決した値を取得する
     *
     * @param string $label
     * @param array $options
     * @return Contract
     */
    public static function make(string $label, array $options = [])
    {
        return self::instance()->make($label, $options);
    }

    /**
     * callableから依存性を解決した値を取得する
     *
     * @param callable $callable
     * @param array $options
     * @return mixed
     */
    public static function call(callable $callable, array $options = [])
    {
        return self::instance()->call($callable, $options);
    }
}
