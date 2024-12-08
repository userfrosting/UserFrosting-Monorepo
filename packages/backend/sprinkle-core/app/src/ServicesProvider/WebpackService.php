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

use Lcharette\WebpackEncoreTwig\JsonManifest;
use Lcharette\WebpackEncoreTwig\JsonManifestInterface;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookup;
use Symfony\WebpackEncoreBundle\Asset\EntrypointLookupInterface;
use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;

class WebpackService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            EntrypointLookupInterface::class => function (Config $config) {
                $path = $config->get('assets.webpack.entrypoints');

                return new EntrypointLookup(strval($path));
            },
            JsonManifestInterface::class     => function (Config $config) {
                $path = $config->get('assets.webpack.manifest');

                return new JsonManifest(strval($path));
            },
        ];
    }
}
