<?php

namespace Takemo101\PHPSupport\Contract\Collection;

/**
 * collection reducer interface
 * collection の reduceメソッドにReducerを実装したインスタンスを渡すことで
 * collectionの要素を変化させることができる
 */
interface Reducer
{
    /**
     * collectionのデータを整理・加工する
     *
     * @param array $elements
     * @return array
     */
    public function reduce(array $elements): array;
}
