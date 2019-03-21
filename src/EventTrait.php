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
 * Trait EventTrait
 * @package event-emitter
 */
trait EventTrait
{
    /**
     * @var string Event name
     */
    protected $name;

    /**
     * @var EventEmitterInterface The event target
     */
    protected $target;

    /**
     * @var EventResults
     */
    protected $results;

    /**
     * @var bool Whether or not to stop event
     */
    protected $stop = false;

    /**
     * Get event name
     *
     * @return string Event name
     */
    public function getName(): string
    {
        if (!$this->name) {
            $this->name = get_class($this);
        }
        return $this->name;
    }

    /**
     * Set the event name
     *
     * @param string $name Event name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get target object from which event was emitted
     *
     * @return EventEmitterInterface Event target object
     */
    public function getTarget(): EventEmitterInterface
    {
        return $this->target;
    }

    /**
     * Set the event target object
     *
     * @param EventEmitterInterface $target Event target object
     * @return void
     */
    public function setTarget(EventEmitterInterface $target): void
    {
        $this->target = $target;
    }

    /**
     * Get event value by name
     *
     * If the event value does not exist, the default value will be returned.
     *
     * @param string $name Value name
     * @param mixed $default Default value to return if event value does not exist
     * @return mixed Event value
     */
    public function getValue(string $name, $default = null)
    {
        return isset($this[$name]) ? $this[$name] : $default;
    }

    /**
     * Set event values
     *
     * @param iterable $values
     */
    public function setValues(iterable $values): void
    {
        foreach ($values as $index => $value) {
            $this[$index] = $value;
        }
    }

    /**
     * Set event result value
     *
     * Add new result value on top of existing results.
     *
     * @param mixed $result Event result value
     * @return void
     */
    public function setResult($result): void
    {
        $this->getResults()->add($result);
    }

    /**
     * Return event results
     *
     * @return EventResults Event results
     */
    public function getResults(): EventResults
    {
        return $this->results ?? new EventResults;
    }

    /**
     * Set event results
     *
     * Overwrites results.
     *
     * @param EventResults|array $results Results array
     * @return void
     */
    public function setResults($results): void
    {
        $this->results = $results instanceof EventResults ? $results : new EventResults($results);
    }

    /**
     * Indicate whether or not to stop propagating this event
     *
     * @param bool $stop Set true to stop propagation
     * @return void
     */
    public function stop(bool $stop = true): void
    {
        $this->stop = $stop;
    }

    /**
     * Has this event indicated event should stop?
     *
     * @return bool True when event is stopped
     */
    public function isStopped(): bool
    {
        return $this->stop;
    }
}
