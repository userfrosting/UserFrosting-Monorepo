<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Twig;

use Illuminate\Filesystem\Filesystem;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Provides helper function to delete the Twig cache directory.
 */
class CacheHelper
{
    /**
     * @param ResourceLocatorInterface $locator The locator service
     */
    public function __construct(
        protected ResourceLocatorInterface $locator,
        protected ?Filesystem $filesystem = null,
    ) {
    }

    /**
     * Function that delete the Twig cache directory content.
     *
     * @return bool true/false if operation is successful
     */
    public function clearCache(): bool
    {
        // Get location
        $path = $this->locator->findResource('cache://twig', true);

        // Get Filesystem instance
        $fs = $this->filesystem ?? new Filesystem();

        // Make sure directory exist and delete it
        if ($path !== null && $fs->exists($path)) {
            return $fs->deleteDirectory($path, true);
        }

        // It's still considered a success if directory doesn't exist yet
        return true;
    }
}
