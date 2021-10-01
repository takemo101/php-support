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
     * @return static
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
     * @return static
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
     * @return static
     */
    public function map(callable $callback);

    /**
     * マップ（キーも設定する ver）
     *
     * @param callable $callback
     * @return static
     */
    public function mapWithKey(callable $callback);

    /**
     * フィルター
     *
     * @param callable $callback
     * @return static
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
     * @return static
     */
    public function replace(array $elements);

    /**
     * マージ
     *
     * @param array $elements
     * @return static
     */
    public function merge(array $elements);

    /**
     * 配列の値から新しい配列を生成する
     *
     * @param array $elements
     * @return static
     */
    public function combine(array $elements);

    /**
     * 配列を結合する
     *
     * @param array $elements
     * @return static
     */
    public function union(array $elements);

    /**
     * 値を検索する
     *
     * @param mixed $element
     * @param boolean $strict
     * @return mixed
     */
    public function search($element, bool $strict = true);
}
