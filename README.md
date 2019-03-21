# Webino Event Emitter

Event Emitter implementation.

[![Build Status](https://img.shields.io/travis/webino/event-emitter/master.svg?style=for-the-badge)](http://travis-ci.org/webino/event-emitter "Master Build Status")
[![Coverage Status](https://img.shields.io/coveralls/github/webino/event-emitter/master.svg?style=for-the-badge)](https://coveralls.io/github/webino/event-emitter?branch=master "Master Coverage Status")
[![Code Quality](https://img.shields.io/scrutinizer/g/webino/event-emitter/master.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/webino/event-emitter/?branch=master "Master Code Quality")
[![Latest Stable Version](https://img.shields.io/github/tag/webino/event-emitter.svg?label=STABLE&style=for-the-badge)](https://packagist.org/packages/webino/event-emitter)


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

## Setup
[![PHP from Packagist](https://img.shields.io/packagist/php-v/webino/event-emitter.svg?style=for-the-badge)](https://php.net "Required PHP version")

```bash
composer require webino\event-emitter
```


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
