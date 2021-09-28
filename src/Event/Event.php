<?php

namespace Takemo101\PHPSupport\Event;

use Takemo101\PHPSupport\Contract\Event\ListenerResolver as Contract;

/**
 * event helper
 */
final class Event
{
    /**
     * event dispatcher
     *
     * @var EventDispatcher|null
     */
    protected static $dispatcher = null;

    /**
     * シングルトンインスタンスをセットする
     *
     * @param EventDispatcher $dispatcher
     * @return void
     */
    public static function setDispatcher(EventDispatcher $dispatcher)
    {
        self::$dispatcher = $dispatcher;
    }

    /**
     * singleton instance
     *
     * @return EventDispatcher
     */
    public static function instance(): EventDispatcher
    {
        if (!self::$dispatcher) {
            self::$dispatcher = new EventDispatcher();
        }

        return self::$dispatcher;
    }

    /**
     * イベントを監視
     *
     * @param string $event
     * @param string|array $listener
     * @return EventDispatcher
     */
    public static function listen(string $event, string|array $listener): EventDispatcher
    {
        return self::instance()->listen($event, $listener);
    }

    /**
     * イベントを監視（複数）
     *
     * @param array $listens
     * @return EventDispatcher
     */
    public static function listens(array $listens): EventDispatcher
    {
        return self::instance()->listens($listens);
    }

    /**
     * イベント通知
     *
     * @param object $event
     * @return EventDispatcher
     */
    public static function notify(object $event): EventDispatcher
    {
        return self::instance()->notify($event);
    }

    /**
     * リスナー解決クラスをセット
     *
     * @param Contract $resolver
     * @return EventDispatcher
     */
    public static function setListenerResolver(Contract $resolver): EventDispatcher
    {
        return self::instance()->setListenerResolver($resolver);
    }
}
