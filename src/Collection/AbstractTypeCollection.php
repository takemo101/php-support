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
     * @return static
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
     * @return static
     */
    public function set($key, $element)
    {
        $this->checkElementType($element);
        return parent::set($key, $element);
    }

    /**
     * 要素を入れ替える
     *
     * @param array $elements
     * @return static
     */
    public function replace(array $elements)
    {
        $this->items = [];

        foreach ($elements as $key => $element) {
            $this->set($key, $element);
        }

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
        $this->checkElements($elements);
        return parent::merge($elements);
    }

    /**
     * 配列の値から新しい配列を生成する
     *
     * @param array $elements
     * @return static
     */
    public function combine(array $elements)
    {
        $this->checkElements($elements);
        return parent::combine($elements);
    }

    /**
     * 配列を結合する
     *
     * @param array $elements
     * @return static
     */
    public function union(array $elements)
    {
        $this->checkElements($elements);
        return parent::union($elements);
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
        $this->checkElementType($element);
        return parent::search($element);
    }
}
