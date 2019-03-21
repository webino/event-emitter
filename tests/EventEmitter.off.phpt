<?php
/**
 * Webino™ (http://webino.sk)
 *
 * @link        https://github.com/webino/event-emitter
 * @copyright   Copyright (c) 2019 Webino, s.r.o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

use Tester\Assert;
use Webino\EventEmitter;

Tester\Environment::setup();

$emitter = new EventEmitter;

$handler = function () {
    return 'Hello';
};

$emitter->on('test.event01', $handler);

// remove handler for all events
$emitter->off($handler);

// remove all handlers for an event
$emitter->off(null, 'example');

// remove all handlers for all events
$emitter->off();


$event = $emitter->emit('example');
$results = $event->getResults();


Assert::same('', (string) $results);
