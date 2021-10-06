<?php

namespace Takemo101\PHPSupport\Collection\Reducer;

use Takemo101\PHPSupport\Contract\Collection\Reducer;

/**
 * 重複がある要素を返す
 */
class Distinct implements Reducer
{
    /**
     * check strict flag
     *
     * @var boolean
     */
    private $strict;

    /**
     * construct
     *
     * @param boolean $strict
     */
    public function __construct(bool $strict = false)
    {
        $this->strict = $strict;
    }

    /**
     * collectionのデータを整理・加工する
     *
     * @param array $elements
     * @return array
     */
    public function reduce(array $elements): array
    {
        $distincts = [];
        $result = [];

        foreach ($elements as $key => $element) {
            if (in_array($element, $distincts, $this->strict)) {
                $result[$key] = $element;
            } else {
                $distincts[] = $element;
            }
        }

        return $result;
    }
}
