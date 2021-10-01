<?php

namespace Takemo101\PHPSupport\Collection;

use Takemo101\PHPSupport\Collection\Support\IterableTrait;
use Takemo101\PHPSupport\Contract\Collection\{
    Collection,
    Iteratable,
};
use OutOfBoundsException;
use JsonSerializable;

/**
 * abstract array collection class
 */
abstract class AbstractArrayCollection implements Collection, Iteratable, JsonSerializable
{
    use IterableTrait;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * 追加
     *
     * @param mixed $element
     * @return static
     */
    public function add($element)
    {
        $this->items[] = $element;

        return $this;
    }

    /**
     * 要素を返す
     *
     * @param mixed $key
     * @param null|mixed $default;
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }

    /**
     * 要素をセット
     *
     * @param mixed $key
     * @param mixed $element
     * @return static
     */
    public function set($key, $element)
    {
        $this->items[$key] = $element;

        return $this;
    }

    /**
     * 削除
     *
     * @param mixed $key
     * @return bool
     */
    public function remove($key): bool
    {
        if ($this->has($key)) {
            unset($this->items[$key]);
            return true;
        }

        return false;
    }

    /**
     * 存在確認
     *
     * @param mixed $key
     * @return boolean
     */
    public function has($key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * キー配列を返す
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * 値配列を返す
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->items);
    }

    /**
     * マップ
     *
     * @param callable $callback
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(
            array_map($callback, $this->items)
        );
    }

    /**
     * マップ（キーも設定する ver）
     *
     * @param callable $callback
     * @return static
     */
    public function mapWithKey(callable $callback)
    {
        $result = [];
        foreach ($this->items as $key => $value) {
            $assoc = call_user_func_array($callback, [$value, $key]);

            foreach ($assoc as $mapKey => $mapValue) {
                $result[$mapKey] = $mapValue;
            }
        }

        return new static($result);
    }

    /**
     * フィルター
     *
     * @param callable $callback
     * @return static
     */
    public function filter(callable $callback)
    {
        return new static(
            array_filter($this->items, $callback)
        );
    }

    /**
     * 最初の要素を返す
     *
     * @throws OutOfBoundsException
     * @return mixed
     */
    public function first()
    {
        if ($this->isEmpty()) {
            throw new OutOfBoundsException('collection is empty');
        }

        reset($this->items);
        return current($this->items);
    }

    /**
     * 最後の要素を返す
     *
     * @return mixed
     */
    public function last()
    {
        if ($this->isEmpty()) {
            throw new OutOfBoundsException('collection is empty');
        }

        $item = end($this->items);
        reset($this->items);

        return $item;
    }

    /**
     * 現在の要素のキーを返す
     *
     * @return mixed
     */
    public function key()
    {
        if ($this->isEmpty()) {
            throw new OutOfBoundsException('collection is empty');
        }

        return key($this->items);
    }

    /**
     * 次の要素を返す
     *
     * @return mixed
     */
    public function next()
    {
        if ($this->isEmpty()) {
            throw new OutOfBoundsException('collection is empty');
        }

        return next($this->items);
    }

    /**
     * 現在の要素を返す
     *
     * @return mixed
     */
    public function current()
    {
        if ($this->isEmpty()) {
            throw new OutOfBoundsException('collection is empty');
        }

        return current($this->items);
    }

    /**
     * 要素を入れ替える
     *
     * @param array $elements
     * @return static
     */
    public function replace(array $elements)
    {
        $this->items = $elements;

        return $this;
    }

    /**
     * マージ
     *
     * @param array $elements
     * @return static
     */
    public function merge(array $elements)
    {
        $this->items = array_merge($this->items, $elements);

        return $this;
    }

    /**
     * 配列の値から新しい配列を生成する
     *
     * @param array $elements
     * @return static
     */
    public function combine(array $elements)
    {
        $this->items = array_combine($this->items, $elements);

        return $this;
    }

    /**
     * 配列を結合する
     *
     * @param array $elements
     * @return static
     */
    public function union(array $elements)
    {
        $this->items = $this->items + $elements;

        return $this;
    }

    /**
     * 値を検索する
     *
     * @param mixed $element
     * @param boolean $strict
     * @return mixed
     */
    public function search($element, bool $strict = true)
    {
        return array_search($element, $this->items, $strict);
    }

    /**
     * 全ての配列を返す
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * serialize value.
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * factory
     *
     * @param array $items
     * @return static
     */
    public static function of(array $items): static
    {
        return new static($items);
    }
}
