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
     * @param EventDispatcherInterface $emitter Event emitter
     * @return void
     */
    public function attachEventEmitter(EventDispatcherInterface $emitter): void;

    /**
     * Detach event emitter from handler.
     *
     * @param EventDispatcherInterface $emitter Event emitter
     * @return void
     */
    public function detachEventEmitter(EventDispatcherInterface $emitter): void;
}
