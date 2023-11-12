<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Filesystem;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemManager as LaravelFilesystemManager;
use League\Flysystem\FilesystemInterface;
use UserFrosting\Config\Config;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Filesystem disk manager service.
 */
class FilesystemManager extends LaravelFilesystemManager
{
    /**
     * Create a new filesystem manager instance.
     *
     * @param Config                   $config
     * @param ResourceLocatorInterface $locator
     */
    public function __construct(
        protected Config $config,
        protected ResourceLocatorInterface $locator,
    ) {
    }

    /**
     * Call a custom driver creator.
     *
     * @param array $config
     *
     * @return Filesystem
     */
    protected function callCustomCreator(array $config): Filesystem
    {
        $driver = $this->customCreators[$config['driver']]($this->config, $config);

        if ($driver instanceof FilesystemInterface) {
            return $this->adapt($driver);
        }

        return $driver;
    }

    /**
     * Get the filesystem connection configuration.
     *
     * @param string $name
     *
     * @return array
     */
    protected function getConfig($name): array
    {
        return $this->config->get("filesystems.disks.{$name}");
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config->get('filesystems.default');
    }

    /**
     * Get the default cloud driver name.
     *
     * @return string
     */
    public function getDefaultCloudDriver(): string
    {
        return $this->config->get('filesystems.cloud');
    }

    /**
     * Overwrite the local driver creation to replace root by locator.
     *
     * @param array $config
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function createLocalDriver(array $config)
    {
        $config['root'] = $this->locator->findResource($config['root'], all: true);

        return parent::createLocalDriver($config);
    }
}
