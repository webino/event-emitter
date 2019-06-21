# Webino Event Emitter

Event Emitter implementation.

[![Build Status](https://img.shields.io/travis/webino/event-emitter/master.svg?style=for-the-badge)](http://travis-ci.org/webino/event-emitter "Master Build Status")
[![Coverage Status](https://img.shields.io/coveralls/github/webino/event-emitter/master.svg?style=for-the-badge)](https://coveralls.io/github/webino/event-emitter?branch=master "Master Coverage Status")
[![Code Quality](https://img.shields.io/scrutinizer/g/webino/event-emitter/master.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/webino/event-emitter/?branch=master "Master Code Quality")
[![Latest Stable Version](https://img.shields.io/github/tag/webino/event-emitter.svg?label=STABLE&style=for-the-badge)](https://packagist.org/packages/webino/event-emitter)

## Recommended Usage

Use event emitter to decouple routine algorithm from an extended logic. 


## Setup
[![PHP from Packagist](https://img.shields.io/packagist/php-v/webino/event-emitter.svg?style=for-the-badge)](https://php.net "Required PHP version")

```bash
composer require webino\event-emitter
```


## Quick Use

Emitting an event:
```php
use Webino\EventEmitter;

$emitter = new EventEmitter;

// registering closure event handler
$emitter->on('example', function () {
    return 'Hello';
});

// emitting custom event
$event = $emitter->emit('example');

/** @var \Webino\EventResults $results */
$results = $event->getResults();

echo $results;

// => Hello
```

Removing an event handler:
```php
use Webino\EventEmitter;

$emitter = new EventEmitter;

$handler = function () {
    return 'Hello';
};

$emitter->on('example', $handler);

// remove handler for all events
$emitter->off($handler);

// remove all handlers for an event
$emitter->off(null, 'example');

// remove all handlers for all events
$emitter->off();
```

Emitting an event until:
```php
use Webino\EventEmitter;

$emitter = new EventEmitter;

$emitter->on('example', function () {
    return 'Special';
});

$event = $emitter->emit('example', function ($result) {
    // when result meets required condition
    if ('Special' === $result) {
        // stop propagation
        return false;
    }
    // or continue
    return true;
});
```


Event handling priority:
```php
use Webino\EventEmitter;

$emitter = new EventEmitter;

$emitter->on('example', function () {
    return 'Begin';
}, $event::BEGIN);

$emitter->on('example', function () {
    return 'Before';
}, $event::BEFORE);

$emitter->on('example', function (Event $event) {
    return 'Main';
}, $event::MAIN);

$emitter->on('example', function () {
    return 'After';
}, $event::AFTER);

$emitter->on('example', function () {
    return 'Finish';
}, $event::FINISH);

// emitting custom event
$event = $emitter->emit('example');

/** @var \Webino\EventResults $results */
$results = $event->getResults();

echo $results;

// => BeginBeforeMainAfterFinish
```

Event handler:
```php
use Webino\EventEmitter;
use Webino\EventHandlerInterface;
use Webino\EventHandlerTrait;

class ExampleEventHandler implements EventHandlerInterface
{
    use EventHandlerTrait;

    protected function initEvents(): void
    {
        $this->on('example', function () {
            return 'Foo';
        });

        $this->on('example', function () {
            return 'Bar';
        });
    }
}

// emitting custom event
$event = $emitter->emit('example');

/** @var \Webino\EventResults $results */
$results = $event->getResults();

echo $results;

// => FooBar
```


## API

**Event**

- *const* BEGIN <br>
  The beginning priority of the event.

- *const* BEFORE <br>
  Priority before main event.

- *const* MAIN <br>
  Main event priority.

- *const* AFTER <br>
  Priority after main event.

- *const* FINISH <br>
  Priority at the end of the event.
  
- *const* OFFSET <br>
  Event priority offset.

- *string* getName() <br>
  Get event name.
  
- *EventEmitterInterface* getTarget() <br>
  Get target object from which event was emitted.
  
- *mixed* getValue(*string* $name, *mixed* $default = null) <br>
  Get event value by name.
  
- *EventResults* getResults() <br>
  Returns event results.
  
- *void* stop(bool $stop = true) <br>
  Indicate whether or not to stop this event.
  
- *bool* isStopped() <br>
  Indicates should stop.


**EventEmitter**

- *void* on( <br>
  *string|EventInterface|EventHandlerInterface* $event, <br>
  *string|array<int, string>|callable* $callback = null, <br> 
  *int* $priority = 1) <br>
  Set event handler.

- *void* off(*callable|EventHandlerInterface* $callback = null, *string|EventInterface* $event = null) <br>
  Remove event handler.

- *EventInterface* emit(*string|EventInterface* $event, *callable* $until = null) <br>
  Invoke handlers.


**EventResults**

- *mixed|null* first() <br>
  Returns first response.

- *mixed|null* last() <br>
  Returns last response.


**EventHandler**

- *void* attachEventEmitter(EventEmitterInterface $emitter) <br>
  Attach event emitter to handler.
  
- *void* detachEventEmitter(EventEmitterInterface $emitter) <br>
  Detach event emitter from handler.


## Development

[![Build Status](https://img.shields.io/travis/webino/event-emitter/develop.svg?style=for-the-badge)](http://travis-ci.org/webino/event-emitter "Develop Build Status")
[![Coverage Status](https://img.shields.io/coveralls/github/webino/event-emitter/develop.svg?style=for-the-badge)](https://coveralls.io/github/webino/event-emitter?branch=develop "Develop Coverage Status")
[![Code Quality](https://img.shields.io/scrutinizer/g/webino/event-emitter/develop.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/webino/event-emitter/?branch=develop "Develop Code Quality")
[![Latest Unstable Version](https://img.shields.io/github/tag-pre/webino/event-emitter.svg?label=PREVIEW&style=for-the-badge)](https://packagist.org/packages/webino/event-emitter "Packagist")


Static analysis:
```bash
composer analyse
```

Coding style check:
```bash
composer check
```

Coding style fix:
```bash 
composer fix
```

Testing:
```bash
composer test
```

Git pre-commit setup:
```bash
ln -s ../../pre-commit .git/hooks/pre-commit
```


## Addendum

[![License](https://img.shields.io/packagist/l/webino/event-emitter.svg?style=for-the-badge)](https://github.com/webino/event-emitter/blob/master/LICENSE.md "BSD-3-Clause License")
[![Total Downloads](https://img.shields.io/packagist/dt/webino/event-emitter.svg?style=for-the-badge)](https://packagist.org/packages/webino/event-emitter "Packagist") 
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/webino/event-emitter.svg?style=for-the-badge)


  Please, if you are interested in this library report any issues and don't hesitate to contribute.
  We will appreciate any contributions on development of this library.

[![GitHub issues](https://img.shields.io/github/issues/webino/event-emitter.svg?style=for-the-badge)](https://github.com/webino/event-emitter/issues)
[![GitHub forks](https://img.shields.io/github/forks/webino/event-emitter.svg?label=Fork&style=for-the-badge)](https://github.com/webino/event-emitter)
