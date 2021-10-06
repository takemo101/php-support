<?php

namespace Takemo101\PHPSupport\Collection\Reducer;

use Takemo101\PHPSupport\Contract\Collection\Reducer;
use Takemo101\PHPSupport\Arr\Arr;

class Except implements Reducer
{
    /**
     * except keys
     *
     * @var string|array
     */
    private $keys;

    /**
     * construct
     *
     * @param string|array $keys
     */
    public function __construct(string|array $keys)
    {
        $this->keys = $keys;
    }

    /**
     * collectionのデータを整理・加工する
     *
     * @param array $elements
     * @return array
     */
    public function reduce(array $elements): array
    {
        return Arr::except($elements, $this->keys);
    }
}
