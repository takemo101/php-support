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
     * @return self
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
     * @return self
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
     * マップ
     *
     * @param callable $callback
     * @return self
     */
    public function map(callable $callback)
    {
        return new static(
            array_map($callback, $this->item)
        );
    }

    /**
     * フィルター
     *
     * @param callable $callback
     * @return self
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
     * 要素を入れ替える
     *
     * @param array $elements
     * @return self
     */
    public function replace(array $elements)
    {
        $this->items = $elements;

        return $this;
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
}
