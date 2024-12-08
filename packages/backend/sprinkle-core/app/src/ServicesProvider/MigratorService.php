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
use UserFrosting\Sprinkle\Core\Database\Migrator\DatabaseMigrationRepository;
use UserFrosting\Sprinkle\Core\Database\Migrator\MigrationLocatorInterface;
use UserFrosting\Sprinkle\Core\Database\Migrator\MigrationRepositoryInterface;
use UserFrosting\Sprinkle\Core\Database\Migrator\SprinkleMigrationLocator;

/*
 * Migrator service.
 *
 * This service handles database migration operations.
*/
class MigratorService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            MigrationRepositoryInterface::class => \DI\autowire(DatabaseMigrationRepository::class),
            MigrationLocatorInterface::class    => \DI\autowire(SprinkleMigrationLocator::class),
        ];
    }
}
