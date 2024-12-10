<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Cache;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Contracts\Cache\Repository as CacheContract;
use PHPUnit\Framework\TestCase;
use UserFrosting\Cache\ArrayStore;
use UserFrosting\Cache\FileStore;

class CacheTest extends TestCase
{
    public string $storage;

    public function setUp(): void
    {
        $this->storage = __DIR__ . '/store';
    }

    /**
     * Test basic array store.
     */
    public function testArrayStore(): void
    {
        // Create the $cache object
        $cacheStore = new ArrayStore();
        $cache = $cacheStore->instance();

        // Assert Instances
        $this->assertInstanceOf(CacheContract::class, $cache); // @phpstan-ignore-line
        $this->assertInstanceOf(Cache::class, $cache); // @phpstan-ignore-line

        // Store "foo" and try to read it
        $cache->forever('foo', 'array');
        $this->assertEquals('array', $cache->get('foo'));
    }

    public function testArrayStorePersistence(): void
    {
        // Create the $cache object
        $cacheStore = new ArrayStore();
        $cache = $cacheStore->instance();

        // Assert Instances
        $this->assertInstanceOf(CacheContract::class, $cache); // @phpstan-ignore-line
        $this->assertInstanceOf(Cache::class, $cache); // @phpstan-ignore-line

        // Doesn't store anything, just tried to read the last one
        // Won't work, because array doesn't save anything
        $this->assertNotEquals('array', $cache->get('foo'));
    }

    /**
     * Test file store.
     */
    public function testFileStore(): void
    {
        // Create the $cache object
        $cacheStore = new FileStore($this->storage);
        $cache = $cacheStore->instance();

        // Assert Instances
        $this->assertInstanceOf(CacheContract::class, $cache); // @phpstan-ignore-line
        $this->assertInstanceOf(Cache::class, $cache); // @phpstan-ignore-line

        // Store "foo" and try to read it
        $cache->forever('foo', 'bar');
        $this->assertEquals('bar', $cache->get('foo'));
    }

    public function testFileStorePersistence(): void
    {
        // Create the $cache object
        $cacheStore = new FileStore($this->storage);
        $cache = $cacheStore->instance();

        // Assert Instances
        $this->assertInstanceOf(CacheContract::class, $cache); // @phpstan-ignore-line
        $this->assertInstanceOf(Cache::class, $cache); // @phpstan-ignore-line

        // Doesn't store anything, just tried to read the last one
        $this->assertEquals('bar', $cache->get('foo'));
    }
}
