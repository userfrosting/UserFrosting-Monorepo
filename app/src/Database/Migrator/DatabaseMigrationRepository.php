<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Migrator;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Collection;
use UserFrosting\Sprinkle\Core\Database\Models\MigrationTable;
use UserFrosting\Sprinkle\Core\Exceptions\MigrationNotFoundException;

/**
 * Repository used to store all migrations run against the database.
 */
class DatabaseMigrationRepository implements MigrationRepositoryInterface
{
    /**
     * Create a new database migration repository instance.
     *
     * @param Capsule        $db
     * @param MigrationTable $model
     */
    public function __construct(
        protected Capsule $db,
        protected MigrationTable $model,
    ) {
        // Make sure repository exist
        if (!$this->exists()) {
            $this->create();
        }
    }

    /**
     * Get list of migrations, with all details regarding batch and cie.
     *
     * @param int|null $steps Number of batch to return. Null to return all.
     * @param bool     $asc   True for ascending order, false for descending.
     *
     * @return Collection Collection of migration from db in the order they where ran
     */
    public function all(?int $steps = null, bool $asc = true): Collection
    {
        $query = $this->model::orderBy('id', ($asc) ? 'asc' : 'desc');

        if (!is_null($steps)) {
            $batch = max($this->getNextBatchNumber() - $steps, 1);
            $query->where('batch', '>=', $batch);
        }

        return $query->get();
    }

    /**
     * {@inheritDoc}
     */
    public function list(?int $steps = null, bool $asc = true): array
    {
        return $this->all($steps, $asc)->pluck('migration')->all();
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $migration): object
    {
        $result = $this->model::forMigration($migration)->first();

        // Throw error if null
        if ($result === null) {
            throw new MigrationNotFoundException();
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function has(string $migration): bool
    {
        return $this->model::forMigration($migration)->exists();
    }

    /**
     * {@inheritDoc}
     */
    public function last(): array
    {
        $query = $this->model::where('batch', $this->getLastBatchNumber());

        return $query->orderBy('id', 'desc')->get()->pluck('migration')->all();
    }

    /**
     * {@inheritDoc}
     */
    public function log(string $migration, ?int $batch = null): bool
    {
        // If no batch number is provided, use next batch number.
        if ($batch === null) {
            $batch = $this->getNextBatchNumber();
        }

        $entry = new $this->model([
            'migration' => $migration,
            'batch'     => $batch,
        ]);

        return $entry->save();
    }

    /**
     * {@inheritDoc}
     */
    public function remove(string $migration): void
    {
        $this->model::forMigration($migration)->delete();
    }

    /**
     * {@inheritDoc}
     */
    public function getNextBatchNumber(): int
    {
        return $this->getLastBatchNumber() + 1;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastBatchNumber(): int
    {
        $batch = $this->model::max('batch');

        // Default to 0 if it's null (empty table)
        return ($batch === null) ? 0 : intval($batch);
    }

    /**
     * {@inheritDoc}
     */
    public function create(): void
    {
        $this->getSchemaBuilder()->create($this->model->getTable(), function (Blueprint $table) {
            // The migrations table is responsible for keeping track of which of the
            // migrations have actually run for the application. We'll create the
            // table to hold the migration file's path as well as the batch ID.
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
        });
    }

    /**
     * {@inheritDoc}
     */
    public function delete(): void
    {
        $this->getSchemaBuilder()->drop($this->model->getTable());
    }

    /**
     * {@inheritDoc}
     */
    public function exists(): bool
    {
        return $this->getSchemaBuilder()->hasTable($this->model->getTable());
    }

    /**
     * Returns the schema builder instance.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchemaBuilder(): Builder
    {
        return $this->getConnection()->getSchemaBuilder();
    }

    /**
     * Resolve the database connection instance.
     *
     * @return \Illuminate\Database\Connection
     */
    // TODO : Inject Connection instead
    public function getConnection(): Connection
    {
        return $this->model->getConnection();
    }
}
