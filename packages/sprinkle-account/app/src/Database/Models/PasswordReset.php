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

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UserFrosting\Sprinkle\Account\Database\Factories\PasswordResetFactory;
use UserFrosting\Sprinkle\Account\Database\Models\Features\HasToken;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PasswordResetInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Password Reset Class.
 *
 * Represents a password reset request for a specific user.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class PasswordReset extends Model implements PasswordResetInterface
{
    use HasFactory;
    use HasToken;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'password_resets';

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'hash',
        'completed',
        'expires_at',
        'completed_at',
    ];

    /**
     * @var string[] The attributes that should be cast.
     */
    protected $casts = [
        'user_id'   => 'integer',
        'completed' => 'boolean',
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
     * Create a new factory instance for the model.
     *
     * @return Factory<PasswordReset>
     */
    protected static function newFactory(): Factory
    {
        return PasswordResetFactory::new();
    }
}
