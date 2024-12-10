<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\Repository;

use PHPUnit\Framework\TestCase;
use UserFrosting\Support\Repository\PathBuilder\SimpleGlobBuilder;
use UserFrosting\Support\Repository\PathBuilder\StreamPathBuilder;
use UserFrosting\UniformResourceLocator\Normalizer;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceStream;

class PathBuilderTest extends TestCase
{
    protected string $basePath;

    protected ResourceLocator $locator;

    public function setUp(): void
    {
        $this->basePath = Normalizer::normalizePath(__DIR__ . '/data');
        $this->locator = new ResourceLocator($this->basePath);

        $this->locator->addStream(new ResourceStream('owls'));

        // Add them one at a time to simulate how they are added in SprinkleManager
        $this->locator->addLocation(new ResourceLocation('core'));
        $this->locator->addLocation(new ResourceLocation('account'));
        $this->locator->addLocation(new ResourceLocation('admin'));
    }

    public function testGlobBuildPaths(): void
    {
        // Arrange
        $builder = new SimpleGlobBuilder($this->locator, 'owls://');

        // Act
        $paths = $builder->buildPaths();

        // Assert
        $this->assertEquals($paths, [
            $this->basePath . 'core/owls/megascops.php',
            $this->basePath . 'core/owls/tyto.php',
            $this->basePath . 'account/owls/megascops.php',
            $this->basePath . 'admin/owls/megascops.php',
        ]);
    }

    public function testBuildPathsToFile(): void
    {
        // Arrange
        $builder = new StreamPathBuilder($this->locator, 'owls://megascops.php');

        // Act
        $paths = $builder->buildPaths();

        // Assert
        $this->assertEquals([
            $this->basePath . 'core/owls/megascops.php',
            $this->basePath . 'account/owls/megascops.php',
            $this->basePath . 'admin/owls/megascops.php',
        ], $paths);
    }
}
