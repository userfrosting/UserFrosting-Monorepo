<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Testing;

use Illuminate\Database\Connection;
use Psr\Container\ContainerInterface;
use UserFrosting\Sprinkle\Core\Database\Migrator\Migrator;

/**
 * Trait o refresh database to fresh state.
 */
trait RefreshDatabase
{
    /**
     * Define hooks to migrate the database before and after each test.
     */
    public function refreshDatabase(): void
    {
        // @phpstan-ignore-next-line Allow for extra protection in case Trait is misused.
        if (!isset($this->ci) || !$this->ci instanceof ContainerInterface) {
            throw new \Exception('CI/Container not available. Make sure you extend the correct TestCase');
        }

        $this->usingInMemoryDatabase() ? $this->refreshInMemoryDatabase() : $this->refreshTestDatabase();
    }

    /**
     * Determine if an in-memory database is being used.
     *
     * @return bool
     */
    public function usingInMemoryDatabase(): bool
    {
        /** @var Connection */
        $connection = $this->ci->get(Connection::class);

        return $connection->getDatabaseName() === ':memory:';
    }

    /**
     * Refresh the in-memory database.
     */
    private function refreshInMemoryDatabase(): void
    {
        /** @var Migrator */
        $migrator = $this->ci->get(Migrator::class);
        $migrator->migrate();
    }

    /**
     * Refresh a conventional test database.
     * Rollback all migrations and start over.
     */
    private function refreshTestDatabase(): void
    {
        /** @var Migrator */
        $migrator = $this->ci->get(Migrator::class);
        $migrator->reset();
        $migrator->migrate();
    }
}
