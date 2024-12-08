<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Listeners;

use Psr\Container\ContainerInterface;
use UserFrosting\Event\AppInitiatedEvent;
use UserFrosting\Event\BakeryInitiatedEvent;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Event Listener for AppInitiatedEvent event.
 * Manually Inject the ContainerInterface into Abstract Model class.
 */
class ModelInitiated
{
    /**
     * @param ContainerInterface $ci
     */
    public function __construct(
        protected ContainerInterface $ci,
    ) {
    }

    /**
     * @param AppInitiatedEvent|BakeryInitiatedEvent $event
     */
    public function __invoke(AppInitiatedEvent|BakeryInitiatedEvent $event): void
    {
        Model::$ci = $this->ci;
    }
}
