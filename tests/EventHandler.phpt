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
use Webino\EventHandlerInterface;
use Webino\EventHandlerTrait;

Tester\Environment::setup();


class TestEventHandler implements EventHandlerInterface
{
    use EventHandlerTrait;

    protected function initEvents(): void
    {
        $this->on('test', function (Event $event) {
            $event['emitted'] = true;
            return 'Foo';
        });

        $this->on('test', function () {
            return 'Bar';
        });
    }
}


$emitter = new EventEmitter;
$handler = new TestEventHandler;
$event = new Event('test');


$emitter->on($handler);

$emitter->emit($event);
$results = $event->getResults();


Assert::false(empty($event['emitted']));
Assert::same('FooBar', (string) $results);
Assert::same('Foo', $results->first());
Assert::same('Bar', $results->last());
