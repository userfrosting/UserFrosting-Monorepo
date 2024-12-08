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

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Seeder\SeedRepositoryInterface;
use UserFrosting\Sprinkle\Core\Seeder\SprinkleSeedsRepository;

/*
 * Return an instance of the database seeder
 */
class SeedService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            SeedRepositoryInterface::class => \DI\autowire(SprinkleSeedsRepository::class),
        ];
    }
}
