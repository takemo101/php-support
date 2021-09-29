<?php

namespace Takemo101\PHPSupport\Event;

use Takemo101\PHPSupport\Contract\Event\ListenerResolver as Contract;
use Takemo101\PHPSupport\Facade\AbstractFacade;

/**
 * event helper
 *
 * @method static EventDispatcher listen(string $event, string|array $listener)
 * @method static EventDispatcher listens(array $listens)
 * @method static EventDispatcher listen(string $event, string|array $listener)
 * @method static EventDispatcher notify(object $event)
 * @method static EventDispatcher setListenerResolver(Contract $resolver):
 *
 * @see \Takemo101\PHPSupport\Event\EventDispatcher
 */
final class Event extends AbstractFacade
{
    /**
     * facade accesser
     *
     * @throws RuntimeException
     * @return string|object
     */
    protected static function accessor(): string|object
    {
        return EventDispatcher::class;
    }

    /**
     * シングルトンインスタンスをセットする
     *
     * @param EventDispatcher $dispatcher
     * @return void
     */
    public static function setDispatcher(EventDispatcher $dispatcher)
    {
        self::binding(function ($c) use ($dispatcher) {
            return $dispatcher;
        });
    }
}
