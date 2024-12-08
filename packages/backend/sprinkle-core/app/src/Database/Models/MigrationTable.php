<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Migrations Model.
 *
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @method static Builder forMigration(string $migration)
 *
 * Represents the migration table, containing the ran migrations.
 */
class MigrationTable extends Model
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'migrations';

    /**
     * @var bool Disable timestamps
     */
    public $timestamps = false;

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'migration',
        'batch',
    ];

    /**
     * Accessor used to remove leading backslash from legacy (V4) migrations
     * records.
     *
     * @param string $value
     *
     * @return string
     */
    public function getMigrationAttribute($value)
    {
        return ltrim($value, '\\');
    }

    /**
     * Scope a query to only include migrations records for a given migration
     * class. Filter both new and legacy (V4) records.
     *
     * @param Builder $query
     * @param string  $migration
     *
     * @return Builder
     */
    public function scopeForMigration(Builder $query, string $migration)
    {
        return $query->where('migration', $migration)
                     ->orWhere('migration', '\\' . $migration);
    }
}
