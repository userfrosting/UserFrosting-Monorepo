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

use DI\Bridge\Slim\CallableResolver;
use Psr\EventDispatcher\ListenerProviderInterface;
use UserFrosting\Sprinkle\SprinkleManager;

/**
 * Implementation for Psr ListenerProviderInterface.
 * Use the Sprinkle Manager to get all the Sprinkle Recipes implementing EventListenerRecipe
 * and their respective registered event to produce a Sprinkle ordered listeners.
 * Also make use of PHP-DI Slim Bridge CallableResolver to revolve callable, class and
 * [class, method] notations with PHP-DI container.
 */
final class SprinkleListenerProvider implements ListenerProviderInterface
{
    public function __construct(
        protected CallableResolver $resolver,
        protected SprinkleManager $sprinkleManager,
    ) {
    }

    /**
     * {@inheritdoc}
     *
     * @return callable[]
     */
    public function getListenersForEvent(object $event): iterable
    {
        $listeners = $this->getRegisteredListeners();

        // Catch if event doesn't have listener
        if (!array_key_exists($event::class, $listeners) || !is_array($listeners[$event::class])) {
            return [];
        }

        foreach ($listeners[$event::class] as $listener) {
            yield $this->resolver->resolve($listener);
        }
    }

    /**
     * Return all registered listeners for all events.
     *
     * @return mixed[]
     */
    public function getRegisteredListeners(): array
    {
        $listeners = [];

        /** @var \UserFrosting\Sprinkle\SprinkleRecipe $sprinkle */
        foreach ($this->sprinkleManager->getSprinkles() as $sprinkle) {
            // Skip any sprinkle recipe that doesn't implement recipe interface
            if (!is_subclass_of($sprinkle, EventListenerRecipe::class)) {
                continue;
            }

            $sprinkleListeners = $sprinkle->getEventListeners();
            $listeners = array_merge_recursive($listeners, $sprinkleListeners);
        }

        return $listeners;
    }
}
