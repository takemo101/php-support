<?php

namespace Takemo101\PHPSupport\Contract\Config;

/**
 * config repository interface
 * コンフィグ操作
 */
interface Repository
{
    /**
     * キーを指定してコンフィグに対して色々な値を設定する
     * configに設定できるものはcallableかコンフィグファイルへのパスか配列など
     *
     * @param string $key
     * @param string|callable $config
     * @param string|null $namespace
     * @return mixed
     */
    public function loadBy(string $key, string|callable $config, ?string $namespace = null);

    /**
     * ディレクトリーからコンフィグを設定する
     *
     * @param string $directory
     * @param string|null $namespace
     * @return mixed
     */
    public function load(string $directory, ?string $namespace = null);

    /**
     * コンフィグデータをマージ
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function merge(string $key, $value);

    /**
     * コンフィグデータを取得
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * コンフィグデータをセット
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function set(string $key, $value);

    /**
     * コンフィグデータの存在チェック
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool;

    /**
     * コンフィグファイルの有無
     *
     * @param string $key
     * @return boolean
     */
    public function exists(string $key): bool;
}
