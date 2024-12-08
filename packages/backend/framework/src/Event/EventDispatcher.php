<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Event;

use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\EventDispatcher\ListenerProviderInterface;
use Psr\EventDispatcher\StoppableEventInterface;

/**
 * Implementation of PSR EventDispatcherInterface.
 *
 * @see https://github.com/Crell/Tukio/blob/003c9a6072fa8032e2bab6a9b43d71266983fc19/src/Dispatcher.php
 */
final class EventDispatcher implements EventDispatcherInterface
{
    public function __construct(
        protected ListenerProviderInterface $provider,
    ) {
    }

    /**
     * Provide all relevant listeners with an event to process.
     *
     * @template TEvent of object
     *
     * @param TEvent $event The object to process.
     *
     * @return (StoppableEventInterface&TEvent)|TEvent The Event that was passed, now modified by listeners.
     */
    public function dispatch(object $event): object
    {
        // If the event is already stopped, this method becomes a no-op.
        if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
            return $event;
        }

        foreach ($this->provider->getListenersForEvent($event) as $listener) {
            $listener($event);
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
                break;
            }
        }

        return $event;
    }
}
