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

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\Exception\LocationNotFoundException;
use UserFrosting\UniformResourceLocator\Exception\StreamNotFoundException;
use UserFrosting\UniformResourceLocator\Normalizer;
use UserFrosting\UniformResourceLocator\ResourceLocation;
use UserFrosting\UniformResourceLocator\ResourceLocationInterface;
use UserFrosting\UniformResourceLocator\ResourceLocator;
use UserFrosting\UniformResourceLocator\ResourceStream;
use UserFrosting\UniformResourceLocator\ResourceStreamInterface;
use UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder;

/**
 * Tests for ResourceLocator.
 */
class ResourceLocatorTest extends TestCase
{
    public function testGetStreamBuilder(): void
    {
        $locator = new ResourceLocator();
        $streamBuilder = $locator->getStreamBuilder();
        $this->assertInstanceOf(StreamBuilder::class, $streamBuilder); // @phpstan-ignore-line
    }

    public function testGetBasePathWithEmptyConstructorArgument(): void
    {
        $locator = new ResourceLocator();
        $this->assertEquals('', $locator->getBasePath());
    }

    public function testSetBasePathWithConstructorArgument(): void
    {
        $locator = new ResourceLocator(__DIR__ . '/Building');
        $this->assertEquals(Normalizer::normalizePath(__DIR__ . '/Building'), $locator->getBasePath());
    }

    public function testAddStream(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->schemeExists('bar'));

        $stream = new ResourceStream('bar', 'foo');
        $locator->addStream($stream);

        $this->assertTrue($locator->schemeExists('bar'));

        $barStream = $locator->getStream('bar');
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $barStream);
    }

    /**
     * @deprecated
     */
    public function testRegisterStream(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->schemeExists('bar'));

        $locator->registerStream('bar', 'foo');

        $this->assertTrue($locator->schemeExists('bar'));

        $barStream = $locator->getStream('bar');
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $barStream);
        $this->assertCount(1, $barStream);
        $this->assertEquals('foo/', $barStream[0]->getPath());
    }

    /**
     * @depends testRegisterStream
     * @deprecated
     */
    public function testRegisterSharedStream(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->schemeExists('bar'));

        $locator->registerStream('bar', 'foo', true);

        $this->assertTrue($locator->schemeExists('bar'));

        $barStream = $locator->getStream('bar');
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $barStream);
        $this->assertCount(1, $barStream);
        $this->assertEquals('foo/', $barStream[0]->getPath());
        $this->assertTrue($barStream[0]->isShared());
    }

    /**
     * @depends testRegisterSharedStream
     * @deprecated
     */
    public function testRegisterSharedStreamShort(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->schemeExists('bar'));

        $locator->registerSharedStream('bar', 'foo');

        $this->assertTrue($locator->schemeExists('bar'));

        $barStream = $locator->getStream('bar');
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $barStream);
        $this->assertCount(1, $barStream);
        $this->assertEquals('foo/', $barStream[0]->getPath());
        $this->assertTrue($barStream[0]->isShared());
    }

    /**
     * @depends testRegisterStream
     */
    public function testRegisterStreamWithOutPath(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->schemeExists('bar'));

        $locator->addStream(new ResourceStream('bar'));

        $this->assertTrue($locator->schemeExists('bar'));

        $barStream = $locator->getStream('bar');
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $barStream);
        $this->assertCount(1, $barStream);
        $this->assertEquals('bar/', $barStream[0]->getPath());
    }

    /**
     * @depends testRegisterStream
     */
    public function testStreamNotFoundException(): void
    {
        $locator = new ResourceLocator();
        $this->expectException(StreamNotFoundException::class);
        $locator->getStream('etc');
    }

    /**
     * @depends testRegisterStream
     */
    public function testAddStreamThrowExceptionOnRestrictedScheme(): void
    {
        $locator = new ResourceLocator();
        $this->expectException(InvalidArgumentException::class);
        $locator->addStream(new ResourceStream('file'));
    }

    /**
     * @depends testRegisterStream
     */
    public function testRemoveStream(): void
    {
        $locator = new ResourceLocator();
        $locator->addStream(new ResourceStream('bar'));
        $this->assertTrue($locator->schemeExists('bar'));
        $locator->removeStream('bar');
        $this->assertFalse($locator->schemeExists('bar'));
    }

    public function testGetStreams(): void
    {
        $locator = new ResourceLocator();
        $locator->addStream(new ResourceStream('bar'));
        $locator->addStream(new ResourceStream('foo'));

        $streams = $locator->getStreams();
        $this->assertCount(2, $streams);
        $this->assertContainsOnlyInstancesOf(ResourceStreamInterface::class, $streams['bar']);
        $this->assertCount(1, $streams['bar']);
        $this->assertEquals('bar/', $streams['bar'][0]->getPath());
    }

    public function testListSchemes(): void
    {
        $locator = new ResourceLocator();
        $locator->addStream(new ResourceStream('bar'));
        $locator->addStream(new ResourceStream('foo'));

        $this->assertEquals(['bar', 'foo'], $locator->listSchemes());
    }

    public function testIsStream(): void
    {
        $locator = new ResourceLocator();
        $locator->addStream(new ResourceStream('foo'));

        $this->assertFalse($locator->isStream('cars://foo.txt'));
        $this->assertTrue($locator->isStream('foo://cars'));
    }

    /**
     * @depends testIsStream
     */
    public function testIsStreamReturnFalseOnBadUri(): void
    {
        $locator = new ResourceLocator();
        $this->assertFalse($locator->isStream('path/to/../../../file.txt'));
    }

    public function testAddLocation(): void
    {
        $locator = new ResourceLocator();

        $location = new ResourceLocation('bar', '/foo');
        $locator->addLocation($location);

        $barLocation = $locator->getLocation('bar');
        $this->assertEquals('/foo/', $barLocation->getPath());
    }

    /**
     * @depends testAddLocation
     * @deprecated
     */
    public function testRegisterLocation(): void
    {
        $locator = new ResourceLocator();

        $locator->registerLocation('bar', '/foo');

        $barLocation = $locator->getLocation('bar');
        $this->assertEquals('/foo/', $barLocation->getPath());
    }

    /**
     * @depends testAddLocation
     * @deprecated
     */
    public function testRegisterLocationWithNoPath(): void
    {
        $locator = new ResourceLocator();

        $locator->registerLocation('blah');

        $barLocation = $locator->getLocation('blah');
        $this->assertEquals('blah/', $barLocation->getPath());
    }

    /**
     * @depends testAddLocation
     */
    public function testGetLocationThrowExceptionIfNotFound(): void
    {
        $locator = new ResourceLocator();
        $this->expectException(LocationNotFoundException::class);
        $locator->getLocation('etc');
    }

    /**
     * @depends testRegisterLocation
     */
    public function testGetLocation(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('bar', '/foo'));
        $locator->addLocation(new ResourceLocation('foo', '/bar'));

        $location = $locator->getLocation('bar');
        $this->assertEquals('/foo/', $location->getPath());

        $location = $locator->getLocation('foo');
        $this->assertEquals('/bar/', $location->getPath());

        $this->expectException(LocationNotFoundException::class);
        $locator->getLocation('foobar');
    }

    /**
     * @depends testRegisterLocation
     */
    public function testGetLocations(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('bar', '/foo'));
        $locator->addLocation(new ResourceLocation('foo', '/bar'));

        $locations = $locator->getLocations();
        $this->assertCount(2, $locations);
        $this->assertContainsOnlyInstancesOf(ResourceLocationInterface::class, $locations);
        $this->assertEquals('/foo/', $locations['bar']->getPath());
    }

    /**
     * @depends testRegisterLocation
     * @see https://github.com/userfrosting/UserFrosting/issues/1243
     */
    public function testGetLocationsForSameName(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('My Name', '/foo'));
        $this->expectException(InvalidArgumentException::class);
        $locator->addLocation(new ResourceLocation('My Name', '/bar'));
    }

    /**
     * @depends testRegisterLocation
     */
    public function testListLocations(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('bar', '/foo'));
        $locator->addLocation(new ResourceLocation('foo', '/bar/'));

        // N.B.: Locations are list with the latest one (top priority) first
        $this->assertEquals(['foo', 'bar'], $locator->listLocations());
    }

    /**
     * @depends testRegisterLocation
     */
    public function testRemoveLocation(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('bar', '/foo/'));
        $locator->addLocation(new ResourceLocation('foo', '/bar'));

        $this->assertCount(2, $locator->getLocations());
        // Remove on location
        $locator->removeLocation('bar');
        $this->assertCount(1, $locator->getLocations());
        $this->assertFalse($locator->locationExist('bar'));
        $this->assertTrue($locator->locationExist('foo'));
        // Remove the second location
        $locator->removeLocation('foo');
        $this->assertCount(0, $locator->getLocations());
    }

    /**
     * @depends testGetLocations
     * @depends testGetStreams
     */
    public function testResourceLocatorReset(): void
    {
        $locator = new ResourceLocator();
        $locator->addLocation(new ResourceLocation('bar'));
        $locator->addLocation(new ResourceLocation('foo'));
        $locator->addStream(new ResourceStream('bar'));
        $locator->addStream(new ResourceStream('foo'));

        $this->assertCount(2, $locator->getStreams());
        $this->assertCount(2, $locator->getLocations());

        $locator->reset();

        $this->assertCount(0, $locator->getStreams());
        $this->assertCount(0, $locator->getLocations());
    }

    /**
     * Test issue for stream with empty path adding an extra `/`
     * Test for issue #16.
     */
    public function testStreamWithEmptyPath(): void
    {
        $locator = new ResourceLocator(__DIR__);
        $locator->addStream(new ResourceStream('sprinkles', ''));
        $locator->addLocation(new ResourceLocation('uploads', 'app/uploads/profile'));

        $result = $locator->getResource('sprinkles://header.json', false);

        //NB.: __DIR__ doesn't end with a '/'.
        $this->assertSame('app/uploads/profile/header.json', $result?->getPath());
    }

    /**
     * With stream pointing to `app/uploads/profile`, we make sure we can't access `app/uploads/MyFile.txt`.
     */
    public function testFindResourceWithBackPath(): void
    {
        $locator = new ResourceLocator(__DIR__);
        $locator->addStream(new ResourceStream('sprinkles', ''));
        $locator->addLocation(new ResourceLocation('uploads', 'app/uploads/profile'));

        $result = $locator->getResource('sprinkles://' . '../MyFile.txt');

        $this->assertNull($result);
    }

    /**
     * Test a location outside of the main path produce the correct relative path.
     */
    public function testFindResourceOutsideMainPath(): void
    {
        $locator = new ResourceLocator(__DIR__ . '/Building/Floors');
        $locator->addStream(new ResourceStream('files'));
        $locator->addLocation(new ResourceLocation('Garage', __DIR__ . '/Building/Garage'));

        $resource = $locator->getResource('files://blah.json');

        $this->assertSame(Normalizer::normalizePath(__DIR__) . 'Building/Garage/files/blah.json', $resource?->getAbsolutePath());
    }

    /**
     * Test a location outside of the main path produce the correct relative path.
     */
    public function testListResourceOutsideMainPath(): void
    {
        $locator = new ResourceLocator(__DIR__ . '/Building/Floors');
        $locator->addStream(new ResourceStream('files'));
        $locator->addLocation(new ResourceLocation('Garage', __DIR__ . '/Building/Garage'));

        $resources = $locator->listResources('files://', true);

        $this->assertSame(Normalizer::normalizePath(__DIR__) . 'Building/Garage/files/blah.json', $resources[0]->getAbsolutePath());
    }

    public function testMultipleStreamWithSameScheme(): void
    {
        $locator = new ResourceLocator(__DIR__);
        $locator->addStream(new ResourceStream('sprinkles', 'Building/Floors/Floor/', true));
        $locator->addStream(new ResourceStream('sprinkles', 'Building/Floors/Floor3', true));

        $result = $locator->getResources('sprinkles://files/test.json');

        // We don't care (yet) about the actual result, we just want to make
        // sure the two streams are picked up.
        $this->assertCount(2, $result);
    }
}
