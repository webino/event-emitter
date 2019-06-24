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
 * Trait EventDispatcherTrait
 * @package event-emitter
 * @since 1.1.0
 */
trait EventDispatcherTrait
{
    /**
     * Subscribed events and their handlers.
     *
     * STRUCTURE:
     * [
     *     <string name> => [
     *         <int priority> => [
     *             0 => [<callable handler>, ...]
     *         ],
     *         ...
     *     ],
     *     ...
     * ]
     *
     * NOTE:
     * This structure helps us to reuse the list of handlers
     * instead of first iterating over it and generating a new one
     * -> In result it improves performance by up to 25% even if it looks a bit strange
     *
     * @var array[]
     */
    protected $events = [];

    /**
     * @var EventInterface|null
     */
    protected $eventPrototype;

    /**
     * Invoke handlers.
     *
     * @api
     * @param string|EventInterface $event Event name or object
     * @param callable|null $until Invoke handlers until callback return value evaluate to true
     * @param EventEmitterInterface|null $target
     * @return EventInterface Event object
     */
    public function emit($event, callable $until = null, EventEmitterInterface $target = null): EventInterface
    {
        $event = $this->normalizeEvent($event);
        $name = $event->getName();

        if (empty($name)) {
            throw (new InvalidEventException('Cannot emit event %s missing a name'))
                ->format($event);
        }

        // get handlers by priority in reverse order
        $handlers = $this->getHandlers($name);

        // set event initial values
        $event->setResults([]);
        $event->stop(false);

        if ($target) {
            $event->setTarget($target);
        } elseif ($this instanceof EventEmitterInterface) {
            $event->setTarget($this);
        }

        // invoke handlers
        foreach ($handlers as $eventHandlers) {
            foreach ($eventHandlers as $subHandlers) {
                foreach ($subHandlers as $callback) {
                    $result = $callback($event);
                    $event->setResult($result);

                    // stop propagation if the event was asked to
                    if ($event->isStopped()) {
                        return $event;
                    }

                    // stop propagation if the result causes our validation callback to return true
                    if ($until && $until($result)) {
                        return $event;
                    }
                }
            }
        }

        return $event;
    }

    /**
     * Set event handler.
     *
     * @api
     * @param string|EventInterface|EventHandlerInterface $event Event name, object or event handler
     * @param callable|null $callback Event handler
     * @param int $priority Handler invocation priority
     * @return void
     */
    public function on($event, $callback = null, int $priority = 0)
    {
        if ($event instanceof EventHandlerInterface && $this instanceof EventDispatcherInterface) {
            $event->attachEventEmitter($this);
            return;
        }

        $event = $this->normalizeEvent($event);
        $name = $event->getName();

        isset($this->events[$name]) or $this->events[$name] = [];
        isset($this->events[$name][(int)$priority]) or $this->events[$name][(int)$priority] = [];
        isset($this->events[$name][(int)$priority][0]) or $this->events[$name][(int)$priority][0] = [];

        $this->events[$name][(int)$priority][0][] = $callback;
    }

    /**
     * Remove event handler.
     *
     * @api
     * @param callable|EventHandlerInterface|null $callback Event handler
     * @param string|EventInterface|null $event Event name or object
     * @return void
     */
    public function off($callback = null, $event = null): void
    {
        if ($callback instanceof EventHandlerInterface && $this instanceof EventEmitterInterface) {
            $callback->detachEventEmitter($this);
            return;
        }

        if (!$event) {
            // remove listeners from all events
            foreach (array_keys($this->events) as $name) {
                $this->off($callback, $name);
            }
            return;
        }

        $event = $this->normalizeEvent($event);
        $name = $event->getName();

        if (!isset($this->events[$name])) {
            return;
        }

        foreach ($this->events[$name] as $priority => $handlers) {
            foreach ($handlers[0] as $index => $subHandler) {
                if ($callback && $subHandler !== $callback) {
                    continue;
                }

                // remove founded listener
                unset($this->events[$name][$priority][0][$index]);

                // remove event if the queue for given priority is empty
                if (empty($this->events[$name][$priority][0])) {
                    unset($this->events[$name][$priority]);
                    break;
                }
            }
        }

        // remove event if the queue given is empty
        if (empty($this->events[$name])) {
            unset($this->events[$name]);
        }
    }

    /**
     * Return listeners sort by priority in reverse order.
     *
     * @param string|null $name Event name
     * @return array Sorted listeners
     */
    protected function getHandlers(string $name = null): array
    {
        if (isset($this->events[$name])) {
            $handlers = $this->events[$name];

            if (isset($this->events['*'])) {
                foreach ($this->events['*'] as $priority => $handlers) {
                    $handlers[$priority][] = $handlers[0];
                }
            }
        } elseif (isset($this->events['*'])) {
            $handlers = $this->events['*'];
        } else {
            $handlers = [];
        }

        krsort($handlers);
        return $handlers;
    }

    /**
     * Return event as object, if any.
     *
     * @param string|EventInterface|object $event Event name or object
     * @return EventInterface Event object
     * @throws InvalidArgumentException Invalid event
     */
    protected function normalizeEvent($event): EventInterface
    {
        if (is_string($event)) {
            $eventClone = clone $this->getEventPrototype();
            $eventClone->setName($event);
            return $eventClone;
        }

        if ($event instanceof EventInterface) {
            return $event;
        }

        throw (new InvalidArgumentException('Expected event as: %s instead of: %s;'))
            ->format('string|EventInterface', $event);
    }

    /**
     * @return EventInterface
     */
    protected function getEventPrototype(): EventInterface
    {
        if (!$this->eventPrototype) {
            if ($this instanceof EventEmitterInterface) {
                $this->eventPrototype = new Event(null, $this);
            } else {
                $this->eventPrototype = new Event;
            }
        }
        return $this->eventPrototype;
    }
}
