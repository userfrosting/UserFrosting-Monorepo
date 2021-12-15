<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2021 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\UniformResourceLocator;

use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocationInterface;

/**
 * Tests for ResourceLocator.
 */
class ResourceLocationTest extends TestCase
{
    public function testResourceLocation(): void
    {
        // Test instance & default values
        $location = new ResourceLocation('');
        $this->assertEquals('', $location->getName());
        $this->assertEquals('', $location->getPath());
    }

    public function testResourceLocationComplete(): void
    {
        $location = new ResourceLocation('bar', '/foo');
        $this->assertEquals('bar', $location->getName());
        $this->assertEquals('/foo/', $location->getPath());
    }

    public function testResourceLocationWithSupressesRightSlashe(): void
    {
        $location = new ResourceLocation('bar', '/foo/');
        $this->assertEquals('bar', $location->getName());
        $this->assertEquals('/foo/', $location->getPath());
    }

    public function testResourceLocationOmittedPathEqualsName(): void
    {
        $location = new ResourceLocation('bar');
        $this->assertEquals('bar', $location->getName());
        $this->assertEquals('bar/', $location->getPath());
    }
}
