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
 * Interface EventHandlerInterface
 * @package event-emitter
 */
interface EventHandlerInterface
{
    /**
     * Attach event emitter to handler.
     *
     * @param EventEmitterInterface $emitter Event emitter
     * @return void
     */
    public function attachEventEmitter(EventEmitterInterface $emitter): void;

    /**
     * Detach event emitter from handler.
     *
     * @param EventEmitterInterface $emitter Event emitter
     * @return void
     */
    public function detachEventEmitter(EventEmitterInterface $emitter): void;
}
