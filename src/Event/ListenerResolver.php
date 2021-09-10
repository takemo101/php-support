<?php

namespace Takemo101\PHPSupport\Event;

use Takemo101\PHPSupport\Contract\Event\ListenerResolver as Contract;
use stdClass;

/**
 * default listener resolver
 */
class ListenerResolver implements Contract
{
    /**
     * create dummy listener
     *
     * @var bool
     */
    private $dummy;

    public function __construct(bool $dummy = true)
    {
        $this->dummy = $dummy;
    }

    /**
     * listener create process
     *
     * @param string $listener
     * @return object
     */
    public function create(string $listener): object
    {
        return $this->dummy ? new stdClass : new $listener;
    }
}
