<?php

namespace Takemo101\PHPSupport\Contract\Collection;

/**
 * collection interface
 * 主に配列操作
 */
interface Collection
{
    /**
     * 追加
     *
     * @param mixed $element
     * @return self
     */
    public function add($element);

    /**
     * 要素を返す
     *
     * @param mixed $key
     * @param null|mixed $default;
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * 要素をセット
     *
     * @param mixed $key
     * @param mixed $element
     * @return self
     */
    public function set($key, $element);

    /**
     * 削除
     *
     * @param mixed $key
     * @return bool
     */
    public function remove($key): bool;

    /**
     * 存在確認
     *
     * @param mixed $key
     * @return boolean
     */
    public function has($key): bool;

    /**
     * キー配列を返す
     *
     * @return array
     */
    public function keys(): array;

    /**
     * 値配列を返す
     *
     * @return array
     */
    public function values(): array;

    /**
     * マップ
     *
     * @param callable $callback
     * @return self
     */
    public function map(callable $callback);

    /**
     * フィルター
     *
     * @param callable $callback
     * @return self
     */
    public function filter(callable $callback);

    /**
     * 最初の要素を返す
     *
     * @return mixed
     */
    public function first();

    /**
     * 最後の要素を返す
     *
     * @return mixed
     */
    public function last();

    /**
     * 現在の要素のキーを返す
     *
     * @return mixed
     */
    public function key();

    /**
     * 次の要素を返す
     *
     * @return mixed
     */
    public function next();

    /**
     * 現在の要素を返す
     *
     * @return mixed
     */
    public function current();

    /**
     * 要素を入れ替える
     *
     * @param array $elements
     * @return self
     */
    public function replace(array $elements);
}
