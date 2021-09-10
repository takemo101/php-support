<?php


namespace Test;

use PHPUnit\Framework\TestCase;
use Takemo101\PHPSupport\Event\{
    EventDispatcher,
    ListenerResolver,
};

/**
 * event test
 */
class EventTest extends TestCase
{
    /**
     * event dispatcher factory
     *
     * @return EventDispatcher
     */
    public function createEventDispatcher(): EventDispatcher
    {
        return new EventDispatcher(
            new ListenerResolver(false)
        );
    }

    public function test__Event__listen__ok()
    {
        $dispatcher = $this->createEventDispatcher();

        $event = new Event('');

        $dispatcher->listen(
            Event::class,
            Listener::class
        );

        $dispatcher->listens([
            Event::class => [
                Listener::class,
                Listener::class,
                Listener::class,
            ]
        ]);

        $this->assertTrue(count($dispatcher->getEventMap($event)) == 1);
    }

    public function test__Event__notify__ok()
    {
        $dispatcher = $this->createEventDispatcher();
        $text = 'text';

        $event = new Event($text);

        $dispatcher->listen(
            Event::class,
            Listener::class
        );

        $this->assertEquals($event->getText(), $text);

        $dispatcher->notify($event);

        $this->assertNotEquals($event->getText(), $text);
    }
}

/**
 * test event class
 */
class Event
{
    /**
     * text string
     *
     * @var string
     */
    private $text;

    public function __construct(string $text)
    {
        $this->setText($text);
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}

/**
 * test listener class
 */
class Listener
{
    public function handle(Event $event)
    {
        $event->setText('handle');
    }
}
