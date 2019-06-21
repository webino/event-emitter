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
 * Interface EventResultsInterface
 * @package event-emitter
 */
interface EventResultsInterface extends \ArrayAccess
{
    /**
     * Add new response.
     *
     * @param mixed $response Event response value
     * @return void
     */
    public function add($response): void;

    /**
     * Returns first response.
     *
     * @return mixed|null
     */
    public function first();

    /**
     * Returns last response.
     *
     * @return mixed|null
     */
    public function last();
}
