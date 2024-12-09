<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Illuminate\Support\Str;
use Psr\EventDispatcher\EventDispatcherInterface;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Event\ResourceLocatorInitiatedEvent;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

class LocatorService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            ResourceLocatorInterface::class => function (
                SprinkleManager $sprinkleManager,
                EventDispatcherInterface $eventDispatcher
            ) {
                // Create instance based on main sprinkle path
                $mainSprinkle = $sprinkleManager->getMainSprinkle();
                $locator = new ResourceLocator($mainSprinkle->getPath());

                // Register all sprinkles locations
                foreach ($sprinkleManager->getSprinkles() as $sprinkle) {
                    $slug = Str::slug($sprinkle->getName());
                    $location = new ResourceLocation($slug, $sprinkle->getPath());
                    $locator->addLocation($location);
                }

                // Dispatch ResourceLocatorInitiated event
                $event = new ResourceLocatorInitiatedEvent($locator);

                /** @var ResourceLocatorInitiatedEvent */
                $event = $eventDispatcher->dispatch($event);

                return $event->getLocator();
            },
        ];
    }
}
