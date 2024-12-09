<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use UserFrosting\Sprinkle\Account\Database\Factories\PersistenceFactory;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PersistenceInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Persistence db Model.
 *
 * Represents the persistence table.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Persistence extends Model implements PersistenceInterface
{
    use HasFactory;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'persistences';

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'token',
        'persistent_token',
        'expires_at',
    ];

    /**
     * @var string[] The attributes that should be cast.
     */
    protected $casts = [
        'user_id'   => 'integer',
    ];

    /**
     * {@inheritDoc}
     */
    public function user(): BelongsTo
    {
        /** @var string */
        $relation = static::$ci?->get(UserInterface::class);

        return $this->belongsTo($relation);
    }

    /**
     * {@inheritDoc}
     */
    public function scopeNotExpired(Builder $query): Builder|QueryBuilder
    {
        return $query->where('expires_at', '>', Carbon::now());
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<Persistence>
     */
    protected static function newFactory(): Factory
    {
        return PersistenceFactory::new();
    }
}
