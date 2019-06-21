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
 * Class EventHandlerTrait
 * @package event-emitter
 */
trait EventHandlerTrait
{
    /**
     * @var EventDispatcherInterface
     */
    private $emitter;

    /**
     * @var callable[]
     */
    private $handlers = [];

    /**
     * Initialize events.
     */
    abstract protected function initEvents(): void;

    /**
     * Handle an event.
     *
     * @param string|EventInterface $event Event name or object
     * @param string|callable|null $callback Event handler
     * @param int $priority
     * @return void
     */
    protected function on($event, $callback = null, $priority = 1): void
    {
        $handler = $this->createCallback($callback);
        $this->emitter->on($event, $handler, $priority);
        $this->handlers[] = $handler;
    }

    /**
     * Attach event emitter to handler.
     *
     * @param EventDispatcherInterface $emitter Event emitter
     * @return void
     */
    public function attachEventEmitter(EventDispatcherInterface $emitter): void
    {
        $this->emitter = $emitter;
        $this->initEvents();
    }

    /**
     * Detach event emitter from handler.
     *
     * @param EventDispatcherInterface $emitter Event emitter
     * @return void
     */
    public function detachEventEmitter(EventDispatcherInterface $emitter): void
    {
        foreach ($this->handlers as $index => $handler) {
            $emitter->off($handler);
            unset($this->handlers[$index]);
        }
    }

    /**
     * @param string|callable|null $callback
     * @return callable
     */
    private function createCallback($callback)
    {
        $callback = is_string($callback) ? [$this, $callback] : $callback;
        return is_callable($callback) ? $callback : function () {
        };
    }
}
