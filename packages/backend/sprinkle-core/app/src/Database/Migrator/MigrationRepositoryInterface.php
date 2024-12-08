<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Migrator;

/**
 * Logs all migrations that have been run.
 */
interface MigrationRepositoryInterface
{
    /**
     * Get list of migrations, with all details regarding batch and cie.
     *
     * @param int|null $steps Number of batch to return. Null to return all.
     * @param bool     $asc   True for ascending order, false for descending.
     *
     * @return array<array{migration: class-string, batch: int}>
     */
    public function all(?int $steps = null, bool $asc = true): array;

    /**
     * Get the list of ran migrations.
     *
     * @param int|null $steps Number of batch to return. Null to return all.
     * @param bool     $asc   True for ascending order, false for descending.
     *
     * @return class-string[] An array of migration class names in the order they where ran
     */
    public function list(?int $steps = null, bool $asc = true): array;

    /**
     * Get details about a specific migration.
     *
     * @param class-string $migration The migration
     *
     * @throws \UserFrosting\Sprinkle\Core\Exceptions\MigrationNotFoundException Should be thrown if migration isn't found.
     *
     * @return array{migration: class-string, batch: int} The migration object
     */
    public function get(string $migration): array;

    /**
     * Check if the requested migration exist in the repository.
     *
     * @param class-string $migration The migration
     *
     * @return bool
     */
    public function has(string $migration): bool;

    /**
     * Get the last migration batch in reserve order they were ran (last one first).
     *
     * @return class-string[]
     */
    public function last(): array;

    /**
     * Log that a migration was run.
     *
     * @param class-string $migration
     * @param int|null     $batch     Batch number to use for logging. Null (default) to use next batch number.
     *
     * @return bool True if success
     */
    public function log(string $migration, ?int $batch = null): bool;

    /**
     * Remove a migration from the log.
     *
     * @param class-string $migration
     */
    public function remove(string $migration): void;

    /**
     * Get the next migration batch number.
     *
     * @return int
     */
    public function getNextBatchNumber(): int;

    /**
     * Get the last migration batch number.
     *
     * @return int
     */
    public function getLastBatchNumber(): int;

    /**
     * Create the migration repository data store.
     */
    public function create(): void;

    /**
     * Delete the migration repository data store.
     */
    public function delete(): void;

    /**
     * Determine if the migration repository exists.
     *
     * @return bool True for success, false for error.
     */
    public function exists(): bool;
}
