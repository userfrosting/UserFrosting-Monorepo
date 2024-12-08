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

use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;
use UserFrosting\ViteTwig\ViteManifest;
use UserFrosting\ViteTwig\ViteManifestInterface;

class ViteService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            ViteManifestInterface::class => function (ResourceLocatorInterface $locator, Config $config) {
                $manifestFile = $config->getString('assets.vite.manifest', 'assets://.vite/manifest.json');
                $manifestFile = (string) $locator->getResource($manifestFile);

                return new ViteManifest(
                    manifestPath: $manifestFile,
                    basePath: $config->getString('assets.vite.base', ''),
                    devEnabled: $config->getBool('assets.vite.dev', true),
                    serverUrl: $config->getString('assets.vite.server', ''),
                );
            },
        ];
    }
}
