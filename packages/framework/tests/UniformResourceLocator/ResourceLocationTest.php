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

use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\ResourceLocation;

/**
 * Tests for ResourceLocator.
 */
class ResourceLocationTest extends TestCase
{
    public function testResourceLocation(): void
    {
        // Test instance & default values
        $location = new ResourceLocation('');
        $this->assertSame('', $location->getName());
        $this->assertSame('', $location->getPath());
    }

    public function testResourceLocationComplete(): void
    {
        $location = new ResourceLocation('bar', '/foo');
        $this->assertSame('bar', $location->getName());
        $this->assertSame('/foo/', $location->getPath());
    }

    public function testResourceLocationWithSuppressesRightSlash(): void
    {
        $location = new ResourceLocation('bar', '/foo/');
        $this->assertSame('bar', $location->getName());
        $this->assertSame('/foo/', $location->getPath());
    }

    public function testResourceLocationOmittedPathEqualsName(): void
    {
        $location = new ResourceLocation('bar');
        $this->assertSame('bar', $location->getName());
        $this->assertSame('bar/', $location->getPath());
    }

    /**
     * @deprecated
     */
    public function testResourceLocationSlug(): void
    {
        $location = new ResourceLocation('Core Sprinkle');
        $this->assertSame('Core Sprinkle', $location->getName());
        $this->assertSame('core-sprinkle', $location->getSlug());
    }
}
