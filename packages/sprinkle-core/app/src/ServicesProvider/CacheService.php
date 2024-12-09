<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Exception;
use Illuminate\Cache\Repository as Cache;
use Psr\Container\ContainerInterface;
use UserFrosting\Cache\ArrayStore;
use UserFrosting\Cache\MemcachedStore;
use UserFrosting\Cache\RedisStore;
use UserFrosting\Cache\TaggableFileStore;
use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Exceptions\BadConfigException;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Setup cache service.
 *
 * @throws BadConfigException If cache handler is not supported
 */
class CacheService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            /**
             * Select cache store based on Config.
             *
             * @throws BadConfigException
             */
            Cache::class             => function (ContainerInterface $ci, Config $config) {
                return match ($config->get('cache.driver')) {
                    'file'      => $ci->get(TaggableFileStore::class)->instance(),
                    'memcached' => $ci->get(MemcachedStore::class)->instance(),
                    'redis'     => $ci->get(RedisStore::class)->instance(),
                    'array'     => $ci->get(ArrayStore::class)->instance(),
                    default     => throw new BadConfigException("Bad cache store type '{$config->get('cache.driver')}' specified in configuration file."),
                };
            },

            /**
             * Inject path from locator into TaggableFileStore.
             */
            TaggableFileStore::class => function (ResourceLocatorInterface $locator) {
                $path = $locator->findResource('cache://', true);

                if ($path === null) {
                    throw new Exception('Cache resource not found. Make sure directory exist.');
                }

                return new TaggableFileStore($path);
            },

            /**
             * Inject memcached config array into MemcachedStore. Also add common "prefix" key into config.
             */
            MemcachedStore::class    => function (Config $config) {
                $config = array_merge($config->get('cache.memcached'), ['prefix' => $config->get('cache.prefix')]);

                return new MemcachedStore($config);
            },

            /**
             * Inject Redis config array into RedisStore. Also add common "prefix" key into config.
             */
            RedisStore::class        => function (Config $config) {
                $config = array_merge($config->get('cache.redis'), ['prefix' => $config->get('cache.prefix')]);

                return new RedisStore($config);
            },
        ];
    }
}
