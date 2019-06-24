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
 * Interface EventDispatcherInterface
 * @package event-emitter
 * @since 1.1.0
 */
interface EventDispatcherInterface
{
    /**
     * Set event handler.
     *
     * @api
     * @param string|EventInterface|EventHandlerInterface $event Event name, object or event handler
     * @param string|array<int, string>|callable|null $callback Event handler
     * @param int $priority Handler invocation priority
     * @return void
     */
    public function on($event, $callback = null, int $priority = 1);

    /**
     * Remove event handler.
     *
     * @api
     * @param callable|EventHandlerInterface|null $callback Event handler
     * @param string|EventInterface|null $event Event name or object
     * @return void
     */
    public function off($callback = null, $event = null): void;

    /**
     * Invoke handlers.
     *
     * @api
     * @param string|EventInterface $event Event name or object
     * @param callable|null $until Invoke handlers until callback return value evaluate to true
     * @param EventEmitterInterface|null $target
     * @return EventInterface Event object
     */
    public function emit($event, callable $until = null, EventEmitterInterface $target = null): EventInterface;
}
