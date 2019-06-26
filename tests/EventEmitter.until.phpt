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

use Tester\Assert;
use Tester\Environment;

Environment::setup();

$emitter = new EventEmitter;

$emitter->on('test.event', function () {
    return 'Special';
});

$event = $emitter->emit('test.event', function ($result) {
    // when result meets required condition
    if ('Special' === $result) {
        // stop event
        return false;
    }
    // or continue
    return true;
});

$results = $event->getResults();


Assert::same('Special', (string) $results);
