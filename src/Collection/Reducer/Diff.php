<?php

namespace Takemo101\PHPSupport\Collection\Reducer;

use Takemo101\PHPSupport\Contract\Collection\Reducer;

/**
 * 要素を比較して存在しないものを返す
 */
class Diff implements Reducer
{
    /**
     * diff elements
     *
     * @var array
     */
    private $elements;

    /**
     * diff assoc flag
     *
     * @var boolean
     */
    private $assoc;

    /**
     * construct
     *
     * @param array $elements
     * @param boolean $assoc
     */
    public function __construct($elements, bool $assoc = false)
    {
        $this->elements = (array) $elements;
        $this->assoc = $assoc;
    }

    /**
     * collectionのデータを整理・加工する
     *
     * @param array $elements
     * @return array
     */
    public function reduce(array $elements): array
    {
        return $this->assoc ?
            array_diff_assoc($elements, $this->elements) :
            array_diff($elements, $this->elements);
    }
}
