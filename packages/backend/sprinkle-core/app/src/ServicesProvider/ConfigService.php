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

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Psr\Container\ContainerInterface;
use UserFrosting\Config\Config;
use UserFrosting\Config\ConfigPathBuilder;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Support\Repository\Loader\ArrayFileLoader;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Site config service.
 *
 * Will attempt to automatically determine which config file(s) to use based on the value of the UF_MODE environment variable.
 */
// TODO : Config required rework in the framework. It required too much info to setup, not enough injection (bad code smell).
// Also, DotEnv usage to get the `.env` must be properly tested. The file location must be set somewhere too.
class ConfigService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            // Set env mode in CI
            'UF_MODE' => function (ResourceLocatorInterface $locator) {
                // Grab any relevant dotenv variables from the .env file
                // located at the locator base path
                try {
                    $dotenv = Dotenv::createImmutable($locator->getBasePath());
                    $dotenv->load();
                } catch (InvalidPathException $e) {
                    // Skip loading the environment config file if it doesn't exist.
                }

                return env('UF_MODE', '');
            },

            Config::class => function (ArrayFileLoader $loader) {
                $config = new Config($loader->load());

                return $config;
            },

            ArrayFileLoader::class => function (ConfigPathBuilder $builder, ContainerInterface $ci) {
                /** @var string */
                $mode = $ci->get('UF_MODE');

                return new ArrayFileLoader($builder->buildPaths($mode));
            },

            ConfigPathBuilder::class => function (ResourceLocatorInterface $locator) {
                return new ConfigPathBuilder($locator, 'config://');
            },
        ];
    }
}
