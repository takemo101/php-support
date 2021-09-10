<?php

namespace Takemo101\PHPSupport\Collection\Support;

use ArrayIterator;
use Traversable;

trait IterableTrait
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * implement IteratorAggregate
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * impelement ArrayAccess
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * impelement ArrayAccess
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * impelement ArrayAccess
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * impelement ArrayAccess
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * implement Countable
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * 自身をコピー
     *
     * @return self
     */
    public function clone()
    {
        return clone $this;
    }

    /**
     * 要素を全て返す
     *
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * 要素が存在するか？
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return $this->count() == 0;
    }
}
