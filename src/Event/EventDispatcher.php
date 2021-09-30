<?php

namespace Takemo101\PHPSupport\Event;

use Takemo101\PHPSupport\Contract\Event\ListenerResolver as Contract;

/**
 * event dispatcher class
 */
class EventDispatcher
{
    /**
     * リスナーの実行メソッド名
     */
    const ListenerMethodName = 'handle';

    /**
     * リスナー解決クラス
     *
     * @var Contract
     */
    private $resolver;

    /**
     * event listener map
     *
     * @var array[]
     */
    private $map = [];

    public function __construct(?Contract $resolver = null)
    {
        $this->setListenerResolver(
            $resolver ?? new ListenerResolver
        );
    }

    /**
     * イベントマップの取得
     *
     * @return string[]
     */
    public function getEventMap(object $event): array
    {
        $class = get_class($event);

        return array_key_exists($class, $this->map) ? $this->map[$class] : [];
    }

    /**
     * イベントを監視
     *
     * @param string $event
     * @param string|array $listener
     * @return self
     */
    public function listen(string $event, string|array $listener): self
    {
        $listeners = is_array($listener) ? $listener : [$listener];

        if (array_key_exists($event, $this->map)) {
            $listeners = array_unique(
                array_merge(
                    $this->map[$event],
                    $listeners
                )
            );
        }

        $this->map[$event] = $listeners;

        return $this;
    }

    /**
     * イベントを監視（複数）
     *
     * @param array $listens
     * @return self
     */
    public function listens(array $listens): self
    {
        foreach ($listens as $event => $listener) {
            $this->listen($event, $listener);
        }

        return $this;
    }

    /**
     * イベント通知
     *
     * @param object $event
     * @return self
     */
    public function notify(object $event): self
    {
        $listeners = $this->getEventMap($event);

        foreach ($listeners as $listener) {
            $this->executeListener($listener, $event);
        }

        return $this;
    }

    /**
     * リスナーの実行
     * handleか__invokeが実装されてなければ何も実行しない
     *
     * @param string $listener
     * @param object $event
     * @return void
     */
    private function executeListener(string $listener, object $event)
    {
        $method = self::ListenerMethodName;

        $listener = $this->resolver->create($listener);

        if (method_exists($listener, $method)) {
            $listener->{$method}($event);
        } else if (method_exists($listener, '__invoke')) {
            $listener($event);
        }
    }

    /**
     * リスナー解決クラスをセット
     *
     * @param Contract $resolver
     * @return self
     */
    public function setListenerResolver(Contract $resolver): self
    {
        $this->resolver = $resolver;

        return $this;
    }
}
