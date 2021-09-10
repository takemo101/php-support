<?php

namespace Takemo101\PHPSupport\Collection;

use Takemo101\PHPSupport\Collection\Support\CheckTypeTrait;

/**
 * abstract instance collection class
 */
abstract class AbstractTypeCollection extends AbstractArrayCollection
{
    use CheckTypeTrait;

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
            $this->set($key, $item);
        }
    }

    /**
     * 追加
     *
     * @param mixed $element
     * @return self
     */
    public function add($element)
    {
        $this->checkElementType($element);
        return parent::add($element);
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
        $this->checkElementType($element);
        return parent::set($key, $element);
    }

    /**
     * マップ
     *
     * @param callable $callback
     * @return mixed|array
     */
    public function map(callable $callback)
    {
        $elements = parent::map($callback);

        return new static($elements);
    }

    /**
     * フィルター
     *
     * @param callable $callback
     * @return mixed|array
     */
    public function filter(callable $callback)
    {
        $elements = parent::filter($callback);

        return new static($elements);
    }

    /**
     * 要素を入れ替える
     *
     * @param array $elements
     * @return self
     */
    public function replace(array $elements)
    {
        $this->items = [];

        foreach ($elements as $key => $element) {
            $this->set($key, $element);
        }

        return $this;
    }
}
