<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Listeners;

use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Bakery\Event\AssetsBuildCommandEvent;

/**
 * Event listener for the AssetsBuildCommand.
 */
class AssetsBuildCommandListener
{
    /**
     * @var string[] Commands to run with Webpack
     */
    protected array $webpackCommands = [
        'assets:install',
        'assets:webpack',
    ];

    /**
     * @var string[] Commands to run with Vite
     */
    protected array $viteCommands = [
        'assets:install',
        // 'assets:vite', // Disabled for now, bake should'n run the dev server
    ];

    public function __construct(protected Config $config)
    {
    }

    /**
     * Handle the AssetsBuildCommandEvent event.
     *
     * @param AssetsBuildCommandEvent $event
     */
    public function __invoke(AssetsBuildCommandEvent $event): void
    {
        $bundler = $this->config->getString('assets.bundler', 'vite');
        $commands = match ($bundler) {
            'vite'    => $this->viteCommands,
            'webpack' => $this->webpackCommands,
            default   => $this->viteCommands,
        };

        $event->addCommands($commands);
    }
}
