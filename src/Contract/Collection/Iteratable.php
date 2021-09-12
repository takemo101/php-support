<?php

namespace Takemo101\PHPSupport\Contract\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;

/**
 * iteratable interface
 * 主に配列のイテレート機能
 */
interface Iteratable extends
    ArrayAccess,
    Countable,
    IteratorAggregate
{
    /**
     * 自身をコピー
     *
     * @return self
     */
    public function clone();

    /**
     * 要素を全て返す
     *
     * @return array
     */
    public function all(): array;

    /**
     * 要素が存在するか？
     *
     * @return boolean
     */
    public function isEmpty(): bool;
}
