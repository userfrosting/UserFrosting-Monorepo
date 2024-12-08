<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Event;

use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * ResourceLocatorInitiated Event. Dispatched when the ResourceLocatorInterface is ready to be used.
 * The locator itself is available in the handler.
 */
class ResourceLocatorInitiatedEvent
{
    /**
     * @param ResourceLocatorInterface $locator
     */
    public function __construct(public ResourceLocatorInterface $locator)
    {
    }

    /**
     * @return ResourceLocatorInterface
     */
    public function getLocator(): ResourceLocatorInterface
    {
        return $this->locator;
    }
}
