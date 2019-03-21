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
 * Class Event
 * @package event-emitter
 */
class Event extends \ArrayObject implements EventInterface
{
    use EventTrait;

    /**
     * Create new event from string or other event object
     *
     * @param string|self|null $event Event name or object
     * @param EventEmitterInterface|null $target Event target object
     * @param array $values Custom event values
     */
    public function __construct($event = null, $target = null, array $values = [])
    {
        parent::__construct();

        // event class as default event name
        $event or $event = get_class($this);

        // init event from string or object
        if (is_string($event)) {
            $this->setName($event);
        } elseif ($event instanceof EventInterface) {
            $this->setTarget($event->getTarget());
            $this->exchangeArray($event->getArrayCopy());
        }

        // set event target and parameters if any
        $target and $this->setTarget($target);
        $values and $this->exchangeArray($values);
    }
}
