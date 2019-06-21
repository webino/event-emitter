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

Tester\Environment::setup();

$emitter = new EventEmitter;
$event = new Event('test');

$emitter->on($event, function (Event $event) {
    $event['emitted'] = true;
    return 'Main';
}, $event::MAIN);

$emitter->on($event, function () {
    return 'Finish';
}, $event::FINISH);

$emitter->on($event, function () {
    return 'Begin';
}, $event::BEGIN);

$emitter->on($event, function () {
    return 'After';
}, $event::AFTER);

$emitter->on($event, function () {
    return 'Before';
}, $event::BEFORE);

$emitter->emit($event);
$results = $event->getResults();

Assert::false(empty($event['emitted']));
Assert::same('BeginBeforeMainAfterFinish', (string) $results);
Assert::same('Begin', $results->first());
Assert::same('Finish', $results->last());
