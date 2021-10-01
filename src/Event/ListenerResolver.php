<?php

namespace Takemo101\PHPSupport\Event;

use Takemo101\PHPSupport\Contract\Event\ListenerResolver as Contract;
use Takemo101\PHPSupport\Facade\Injector;

/**
 * default listener resolver
 */
class ListenerResolver implements Contract
{
    /**
     * listener create process
     *
     * @param string $listener
     * @return object
     */
    public function create(string $listener): object
    {
        return Injector::make($listener);
    }
}
