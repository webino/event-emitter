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
 * Interface EventInterface
 * @package event-emitter
 */
interface EventInterface extends \ArrayAccess
{
    /**
     * The beginning of the event.
     */
    const BEGIN = 9000;

    /**
     * Before main event.
     */
    const BEFORE = 5000;

    /**
     * Main event.
     */
    const MAIN = 1;

    /**
     * After main event.
     */
    const AFTER = -5000;

    /**
     * At the end of the event.
     */
    const FINISH = -9000;

    /**
     * Event priority offset.
     */
    const OFFSET = 10;

    /**
     * Get event name.
     *
     * @return string Event name
     */
    public function getName(): string;

    /**
     * Set event name.
     *
     * @param string $name Event name
     * @return void
     */
    public function setName(string $name): void;

    /**
     * Get target object from which event was emitted.
     *
     * @return EventEmitterInterface Event target object
     */
    public function getTarget(): EventEmitterInterface;

    /**
     * Set the event target object.
     *
     * @param EventEmitterInterface $target Event target object
     * @return void
     */
    public function setTarget(EventEmitterInterface $target): void;

    /**
     * Get event value by name.
     *
     * If the event value does not exist, the default value will be returned.
     *
     * @param string $name Value name
     * @param mixed $default Default value to return if event value does not exist
     * @return mixed Event value
     */
    public function getValue(string $name, $default = null);

    /**
     * Set event values.
     *
     * @param iterable $values
     */
    public function setValues(iterable $values): void;

    /**
     * Returns event results.
     *
     * @return EventResults Event results
     */
    public function getResults(): EventResults;

    /**
     * Set event results.
     *
     * Overwrites results.
     *
     * @param EventResults|array $results Results array
     * @return void
     */
    public function setResults($results): void;

    /**
     * Set event result value.
     *
     * Add new result value on top of existing results.
     *
     * @param mixed $result Event result value
     * @return void
     */
    public function setResult($result): void;

    /**
     * Indicate whether or not to stop this event.
     *
     * @param bool $stop Set true to stop event
     * @return void
     */
    public function stop(bool $stop = true): void;

    /**
     * Indicates should stop.
     *
     * @return bool True when event is stopped
     */
    public function isStopped(): bool;
}
