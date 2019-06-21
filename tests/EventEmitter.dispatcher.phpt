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
use Webino\Event;
use Webino\EventEmitter;
use Webino\EventDispatcher;

Tester\Environment::setup();

$dispatcher = new EventDispatcher;

$emitter = new EventEmitter;
$emitter->setEventDispatcher($dispatcher);

$event = new Event('test');


$dispatcher->on($event, function (Event $event) {
    $event['emitted'] = true;
    return 'Foo';
});

$dispatcher->on($event, function () {
    return 'Bar';
});

$emitter->emit($event);
$results = $event->getResults();


Assert::false(empty($event['emitted']));
Assert::same('FooBar', (string) $results);
Assert::same('Foo', $results[0]);
