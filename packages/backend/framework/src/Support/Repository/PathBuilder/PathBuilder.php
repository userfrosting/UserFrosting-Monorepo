<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Repository\PathBuilder;

use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Base PathBuilder class.
 */
abstract class PathBuilder
{
    /**
     * Create the loader.
     *
     * @param ResourceLocatorInterface $locator
     * @param string                   $uri
     */
    public function __construct(
        protected ResourceLocatorInterface $locator,
        protected string $uri
    ) {
    }

    /**
     * Build out the ordered list of file paths, using the designated locator and uri for this loader.
     *
     * @return string[]
     */
    abstract public function buildPaths(): array;
}
