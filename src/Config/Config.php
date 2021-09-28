<?php

namespace Takemo101\PHPSupport\Config;

use Takemo101\PHPSupport\Contract\Config\Repository as Contract;

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
     * シングルトンインスタンスをセットする
     *
     * @param Contract $repository
     * @return void
     */
    public static function setRepository(Contract $repository)
    {
        self::$repository = $repository;
    }

    /**
     * singleton instance
     *
     * @return Contract
     */
    public static function instance(): Contract
    {
        if (!self::$repository) {
            self::$repository = new Repository();
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
     * @return Contract
     */
    public static function loadBy(string $key, string|callable $config, ?string $namespace = null): Contract
    {
        return self::instance()->loadBy($key, $config, $namespace);
    }

    /**
     * ディレクトリーからコンフィグを設定する
     *
     * @param string $directory
     * @param string|null $namespace
     * @return Contract
     */
    public static function load(string $directory, ?string $namespace = null): Contract
    {
        return self::instance()->load($directory, $namespace);
    }

    /**
     * コンフィグデータをマージ
     *
     * @param string $key
     * @param mixed $value
     * @return Contract
     */
    public static function merge(string $key, $value): Contract
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
     * @return Contract
     */
    public static function set(string $key, $value): Contract
    {
        return self::instance()->set($key, $value);
    }

    /**
     * コンフィグデータの存在チェック
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key): bool
    {
        return self::instance()->has($key);
    }

    /**
     * コンフィグファイルの有無
     *
     * @param string $key
     * @return boolean
     */
    public static function exists(string $key): bool
    {
        return self::instance()->exists($key);
    }
}
