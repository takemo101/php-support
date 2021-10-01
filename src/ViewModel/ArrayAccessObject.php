<?php

namespace Takemo101\PHPSupport\ViewModel;

use ArrayAccess;
use IteratorAggregate;
use Countable;
use JsonSerializable;
use ArrayIterator;
use Takemo101\PHPSupport\Arr\Arr;

class ArrayAccessObject implements ArrayAccess, IteratorAggregate, Countable, JsonSerializable
{
    /**
     * resources
     *
     * @var array
     */
    protected $resources = [];

    /**
     * construct
     *
     * @param array $resources
     */
    public function __construct(array $resources = [])
    {
        $this->resources = $resources;
    }

    // countable

    public function count(): int
    {
        return count($this->resources);
    }

    // magic method

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function __get($name)
    {
        $resource = $this->offsetGet($name);
        return is_array($resource) ? new static($resource) : $resource;
    }

    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    public function __unset($name)
    {
        $this->offsetUnset($name);
    }

    // array access

    public function offsetExists($key): bool
    {
        return Arr::has($this->resources, $key);
    }

    public function offsetGet($key)
    {
        return Arr::get($this->resources, $key);
    }

    public function offsetSet($key, $value): void
    {
        Arr::set($this->resources, $key, $value);
    }

    public function offsetUnset($key): void
    {
        Arr::forget($this->resources, $key);
    }

    // IteratorAggregate

    public function getIterator()
    {
        return new ArrayIterator($this->resources);
    }

    /**
     * to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->resources;
    }

    /**
     * for json array
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * factory from view model
     *
     * @param AbstractModel $model
     * @return static
     */
    public static function fromModel(AbstractModel $model): static
    {
        return new static($model->toArray());
    }
}
