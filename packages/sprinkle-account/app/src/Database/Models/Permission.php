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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use UserFrosting\Sprinkle\Account\Database\Factories\PermissionFactory;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Model;
use UserFrosting\Sprinkle\Core\Database\Relations\BelongsToManyThrough;

/**
 * Permission Class.
 *
 * Represents a permission for a role or user.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Permission extends Model implements PermissionInterface
{
    use HasFactory;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'permissions';

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug',
        'name',
        'conditions',
        'description',
    ];

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
     * Delete this permission from the database, removing associations with roles.
     */
    public function delete()
    {
        // Remove all role associations
        $this->roles()->detach();

        // Delete the permission
        return parent::delete();
    }

    /**
     * {@inheritDoc}
     */
    public function roles(): BelongsToMany
    {
        /** @var string */
        $relation = static::$ci?->get(RoleInterface::class);

        return $this->belongsToMany($relation, 'permission_roles', 'permission_id', 'role_id')->withTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function scopeForRole(Builder $query, int|RoleInterface $role): Builder|QueryBuilder
    {
        if ($role instanceof RoleInterface) {
            $roleId = $role->id;
        } else {
            $roleId = $role;
        }

        return $query->whereHas('roles', function ($q) use ($roleId) {
            $q->where('roles.id', $roleId);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function scopeNotForRole(Builder $query, int|RoleInterface $role): Builder|QueryBuilder
    {
        if ($role instanceof RoleInterface) {
            $roleId = $role->id;
        } else {
            $roleId = $role;
        }

        return $query->whereDoesntHave('roles', function ($q) use ($roleId) {
            $q->where('roles.id', $roleId);
        });
    }

    /**
     * {@inheritDoc}
     */
    public function users(): BelongsToManyThrough
    {
        /** @var class-string */
        $userRelation = static::$ci?->get(UserInterface::class);

        /** @var class-string */
        $roleRelation = static::$ci?->get(RoleInterface::class);

        return $this->belongsToManyThrough(
            $userRelation,
            $roleRelation,
            firstJoiningTable: 'permission_roles',
            secondJoiningTable: 'role_users',
            secondRelatedKey: 'user_id',
        );
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<Permission>
     */
    protected static function newFactory(): Factory
    {
        return PermissionFactory::new();
    }
}
