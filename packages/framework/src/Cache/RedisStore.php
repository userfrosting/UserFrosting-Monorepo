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

use Illuminate\Container\Container;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Redis\RedisManager;
use UserFrosting\Cache\Patch\Redis\RedisStore as PatchedRedisStore;

/**
 * Setup a cache instance in a defined namespace using the `redis` driver.
 */
class RedisStore extends AbstractStore
{
    /**
     * @var array<mixed> Memcached config.
     */
    protected array $config;

    /**
     * Accept the redis server configuration.
     *
     * @param array<mixed> $config (default: [])
     */
    public function __construct($config = [])
    {
        // Setup Redis server config
        $this->config = [
            'default' => array_merge([
                'host'     => '127.0.0.1',
                'password' => null,
                'port'     => 6379,
                'database' => 0,
                'prefix'   => '',
            ], $config),
        ];
    }

    /**
     * Create the Illuminate FileStore.
     */
    public function getStore(): Store
    {
        // @phpstan-ignore-next-line - Use container as dummy app
        $redis = new RedisManager(new Container(), 'predis', $this->config);

        return new PatchedRedisStore($redis, $this->config['default']['prefix']);
    }
}
