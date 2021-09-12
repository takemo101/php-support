<?php

namespace Takemo101\PHPSupport\Contract\Event;

/**
 * listener resolver interface
 */
interface ListenerResolver
{
    /**
     * リスナーの生成処理
     *
     * @param string $listener
     * @return object
     */
    public function create(string $listener): object;
}
