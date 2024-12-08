<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\UniformResourceLocator;

/**
 * Tests for ResourceLocator.
 */
class BuildingLocatorWithBasePathTest extends BuildingLocatorTest
{
    /** @var string */
    protected $basePath = __DIR__.'/Building';  // No trailing slash
}
