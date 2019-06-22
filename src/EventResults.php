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
 * Class EventResults
 * @package event-emitter
 */
class EventResults implements
    EventResultsInterface
{
    /**
     * @var array
     */
    protected $results = [];

    /**
     * Create event Results from array values.
     *
     * @param array $results Event Results values array
     */
    public function __construct(array $results = [])
    {
        $this->results = $results;
    }

    /**
     * Add new response.
     *
     * @internal
     * @param mixed $response Event response value
     * @return void
     */
    public function add($response): void
    {
        $this->results[] = $response;
    }

    /**
     * Returns first response.
     *
     * @api
     * @return mixed|null
     */
    public function first()
    {
        return $this->results[0] ?: null;
    }

    /**
     * Returns last response.
     *
     * @api
     * @return mixed|null
     */
    public function last()
    {
        $index = count($this->results) - 1;
        return $this->results[$index] ?: null;
    }

    /**
     * Return results as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->results;
    }

    /**
     * Whether a offset exists.
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->results);
    }

    /**
     * Offset to retrieve.
     *
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->results[$offset];
    }

    /**
     * Offset to set.
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->results[$offset] = $value;
    }

    /**
     * Offset to unset.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->results[$offset]);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return join('', $this->results);
    }
}
