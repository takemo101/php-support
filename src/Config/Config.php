<?php

namespace Takemo101\PHPSupport\Config;

/**
 * config helper
 */
final class Config
{
    /**
     * config repository
     *
     * @var Repository|null
     */
    protected static $repository = null;

    /**
     * singleton instance
     *
     * @param string|null $directory
     * @return Repository
     */
    public static function instance(?string $directory = null): Repository
    {
        if (!self::$repository) {
            self::$repository = new Repository($directory);
        }

        return self::$repository;
    }

    /**
     * キーを指定してコンフィグに対して色々な値を設定する
     * configに設定できるものはcallableかコンフィグファイルへのパスか配列など
     *
     * @param string $key
     * @param string|callable $config
     * @param string|null $namespace
     * @return Repository
     */
    public static function loadBy(string $key, string|callable $config, ?string $namespace = null): Repository
    {
        return self::instance()->loadBy($key, $config, $namespace);
    }

    /**
     * ディレクトリーからコンフィグを設定する
     *
     * @param string $directory
     * @param string|null $namespace
     * @return Repository
     */
    public static function load(string $directory, ?string $namespace = null): Repository
    {
        return self::instance()->load($directory, $namespace);
    }

    /**
     * コンフィグデータをマージ
     *
     * @param string $key
     * @param mixed $value
     * @return Repository
     */
    public static function merge(string $key, $value): Repository
    {
        return self::instance()->merge($key, $value);
    }

    /**
     * コンフィグデータを取得
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        return self::instance()->get($key, $default);
    }

    /**
     * コンフィグデータをセット
     *
     * @param string $key
     * @param mixed $value
     * @return Repository
     */
    public static function set(string $key, $value): Repository
    {
        return self::instance()->set($key, $value);
    }

    /**
     * コンフィグデータの存在チェック
     *
     * @param string $key
     * @return boolean
     */
    public static function has($key): bool
    {
        return self::instance()->has($key);
    }

    /**
     * コンフィグファイルの有無
     *
     * @param string $key
     * @return boolean
     */
    public static function exists($key): bool
    {
        return self::instance()->exists($key);
    }
}
