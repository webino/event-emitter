<?php
/**
 * Webino™ (http://webino.sk)
 *
 * @link        https://github.com/webino/event-emitter
 * @copyright   Copyright (c) 2019 Webino, s.r.o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace Webino;

/**
 * Trait EventEmitterTrait
 * @package event-emitter
 */
trait EventEmitterTrait
{
    /**
     * @var EventDispatcherInterface|null
     */
    protected $eventDispatcher;

    /**
     * Returns event dispatcher.
     *
     * @return EventDispatcherInterface|null
     */
    public function getEventDispatcher(): EventDispatcherInterface
    {
        if (!$this->eventDispatcher) {
            $this->setEventDispatcher(new EventDispatcher);
        }

        return $this->eventDispatcher;
    }

    /**
     * Inject event dispatcher.
     *
     * @param EventDispatcherInterface $dispatcher
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher): void
    {
        $this->eventDispatcher = $dispatcher;
    }

    /**
     * Invoke handlers.
     *
     * @param string|EventInterface $event Event name or object
     * @param callable|null $until Invoke handlers until callback return value evaluate to true
     * @return EventInterface Event object
     * @throws InvalidEventException Invalid event
     */
    public function emit($event, callable $until = null): EventInterface
    {
        return $this->getEventDispatcher()->emit($event, $until);
    }

    /**
     * Set event handler.
     *
     * @param string|EventInterface|EventHandlerInterface $event Event name, object or event handler
     * @param callable|null $callback Event handler
     * @param int $priority Handler invocation priority
     * @return void
     */
    public function on($event, $callback = null, int $priority = 0)
    {
        $this->getEventDispatcher()->on($event, $callback, $priority);
    }

    /**
     * Remove event handler.
     *
     * @param callable|EventHandlerInterface|null $callback Event handler
     * @param string|EventInterface|null $event Event name or object
     * @return void
     */
    public function off($callback = null, $event = null): void
    {
        $this->getEventDispatcher()->off($callback, $event);
    }
}
