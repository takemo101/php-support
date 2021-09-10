<?php

namespace Takemo101\PHPSupport\Contract\Event;

/**
 * listener resolver interface
 */
interface ListenerResolver
{
    public function create(string $listener): object;
}
