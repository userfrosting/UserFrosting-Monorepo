<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\UniformResourceLocator\StreamWrapper;

use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder;
use UserFrosting\UniformResourceLocator\StreamWrapper\StreamInterface;

/**
 * Tests for StreamBuilder.
 */
class StreamBuilderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function setUp(): void
    {
        parent::setUp();

        // Remove streams that would have been registered by another test
        @stream_wrapper_unregister('foo');
    }

    public function testStreamBuilder(): void
    {
        // Create mock handler
        $handler = Mockery::mock(StreamInterface::class);

        $builder = new StreamBuilder();

        // Assert init state
        $this->assertNotContains('foo', $builder->getStreams());
        $this->assertFalse($builder->isStream('foo'));

        // Add streams
        $builder->add('foo', $handler::class);

        // Assert new state
        $streams = $builder->getStreams();
        $this->assertContains('foo', $streams);
        $this->assertTrue($builder->isStream('foo'));

        // Remove streams
        $builder->remove('foo');

        // Assert init state
        $this->assertNotContains('foo', $builder->getStreams());
        $this->assertFalse($builder->isStream('foo'));
    }

    public function testStreamBuilderForConstructor(): void
    {
        // Create mock handler
        $handler = Mockery::mock(StreamInterface::class);

        $builder = new StreamBuilder([
            'foo' => $handler::class,
        ]);

        $this->assertContains('foo', $builder->getStreams());

        // Remove stream for next test
        $builder->remove('foo');
    }

    public function testStreamBuilderWithInvalidType(): void
    {
        $builder = new StreamBuilder();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Stream 'foo' has unknown or invalid type.");
        $builder->add('foo', \stdClass::class);
    }

    public function testStreamBuilderWithRegisterException(): void
    {
        $handler = Mockery::mock(StreamInterface::class);
        $builder = new StreamBuilder();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Stream 'file' could not be initialized or has already been initialized.");
        $builder->add('file', $handler::class); // File is registered by default
    }
}
