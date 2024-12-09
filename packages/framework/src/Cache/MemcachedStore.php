<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Cache;

use Illuminate\Cache\MemcachedConnector;
use Illuminate\Cache\MemcachedStore as IlluminateMemcachedStore;
use Illuminate\Contracts\Cache\Store;

/**
 * Setup a cache instance in a defined namespace using the `memcached` driver.
 */
class MemcachedStore extends AbstractStore
{
    /**
     * @var array<mixed> Memcached config.
     */
    protected array $config;

    /**
     * Accept the memcached server configuration.
     *
     * @param array<mixed> $config (default: [])
     */
    public function __construct(array $config = [])
    {
        // Merge argument config with default one
        $this->config = array_merge([
            'host'   => '127.0.0.1',
            'port'   => 11211,
            'weight' => 100,
            'prefix' => '',
        ], $config);
    }

    /**
     * Create the Illuminate FileStore.
     */
    public function getStore(): Store
    {
        $connector = new MemcachedConnector();
        $memcached = $connector->connect([$this->config]);

        return new IlluminateMemcachedStore($memcached, $this->config['prefix']);
    }
}
