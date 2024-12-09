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
use UserFrosting\UniformResourceLocator\ResourceStream;

/**
 * Tests for ResourceLocator.
 */
class ResourceStreamTest extends TestCase
{
    /**
     * Test ResourceStream Class.
     */
    public function testResourceStream(): void
    {
        // Test instance & default values
        $stream = new ResourceStream('');
        $this->assertEquals('', $stream->getScheme());
        $this->assertEquals('', $stream->getPath());
        $this->assertFalse($stream->isShared());
    }

    /**
     * Now try again with the info in the constructor.
     */
    public function testResourceStreamComplete(): void
    {
        $stream = new ResourceStream('bar', '/foo', true);
        $this->assertEquals('bar', $stream->getScheme());
        $this->assertEquals('/foo/', $stream->getPath());
        $this->assertTrue($stream->isShared());
    }

    /**
     * When no path is defined, the name should be used.
     */
    public function testResourceStreamNoPath(): void
    {
        $stream = new ResourceStream('etc');
        $this->assertEquals('etc', $stream->getScheme());
        $this->assertEquals('etc/', $stream->getPath());
    }
}
