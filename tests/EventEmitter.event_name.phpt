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

$emitted = false;
$emitter = new EventEmitter;


$emitter->on('test', function () use (&$emitted) {
    $emitted = true;
    return 'Foo';
});

$emitter->on('test', function () {
    return 'Bar';
});

$event = $emitter->emit('test');
$results = $event->getResults();


Assert::true($emitted);
Assert::same('FooBar', (string) $results);
Assert::same('Foo', $results->first());
Assert::same('Bar', $results->last());
