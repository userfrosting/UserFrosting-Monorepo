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
use PHPUnit\Framework\TestCase;

abstract class StoreTestCase extends TestCase
{
    /**
     * @return Cache
     */
    abstract protected function createStore(): Cache;

    /**
     * Ensure consistent behaviors across all cache providers.
     */
    public function testPutValueHandling(): void
    {
        $cache = $this->createStore();

        // string
        $cache->put('string', 'foobar');
        $this->assertSame('foobar', $cache->get('string'));

        // int
        $cache->put('string', 999);
        $this->assertSame(999, $cache->get('string'));

        // array filled
        $cache->put('array_filled', ['a', 'b', 'c', 1, 2, 3]);
        $this->assertSame(null, $cache->get('array'));

        // array empty
        $cache->put('array_empty', []);
        $this->assertSame(null, $cache->get('array'));

        // object
        $cache->put('object', (object) []);
        $this->assertSame(null, $cache->get('array'));
    }
}
