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

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use UserFrosting\Sprinkle\Account\Database\Factories\ActivityFactory;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\ActivityInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Activity Model.
 *
 * Represents a single user activity at a specified point in time.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Activity extends Model implements ActivityInterface
{
    use HasFactory;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'activities';

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'ip_address',
        'user_id',
        'type',
        'occurred_at',
        'description',
    ];

    /**
     * @var string[] The attributes that should be cast.
     */
    protected $casts = [
        'user_id'     => 'integer',
        'occurred_at' => 'datetime',
    ];

    /**
     * @var bool Disable timestamps for this class.
     */
    public $timestamps = false;

    /**
     * Cast nullable description to empty string if null.
     *
     * @param string|null $value
     *
     * @return string
     */
    public function getDescriptionAttribute(?string $value): string
    {
        return $value ?? '';
    }

    /**
     * {@inheritDoc}
     */
    public function scopeJoinUser(Builder $query): Builder|QueryBuilder
    {
        return $query->select('activities.*')
            ->join('users', 'activities.user_id', '=', 'users.id');
    }

    /**
     * {@inheritDoc}
     */
    public function scopeForType(Builder $query, string $type): Builder|QueryBuilder
    {
        return $query->where('type', $type);
    }

    /**
     * {@inheritDoc}
     */
    public function user(): BelongsTo
    {
        /** @var string */
        $relation = static::$ci?->get(UserInterface::class);

        return $this->belongsTo($relation, 'user_id');
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<Activity>
     */
    protected static function newFactory(): Factory
    {
        return ActivityFactory::new();
    }
}
