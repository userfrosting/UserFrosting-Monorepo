<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Sprunje;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * Implements Sprunje for retrieving a list of permissions for a specified user.
 */
class UserPermissionSprunje extends Sprunje
{
    protected string $name = 'user_permissions';

    protected array $sortable = [
        'name',
        'properties',
    ];

    protected array $filterable = [
        'name',
        'properties',
        'info',
    ];

    protected array $excludeForAll = [
        'info',
    ];

    /**
     * WARNING : If using dependency injection, the user will be empty. To get
     * permissions for a specific user, consider manually creating the class and
     * passing the user ar constructor argument.
     * eg.: new UserPermissionSprunje($myUser);.
     *
     * @param UserInterface $user The user to retrieve permissions for.
     */
    public function __construct(
        protected UserInterface $user,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery(): EloquentBuilder|QueryBuilder|Relation|Model
    {
        return $this->user->permissions()->withVia('roles_via');
    }

    /**
     * Filter LIKE the slug, conditions, or description.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterInfo(EloquentBuilder|QueryBuilder|Relation $query, string $value): static
    {
        return $this->filterProperties($query, $value);
    }

    /**
     * Filter LIKE the slug, conditions, or description for the slug/condition
     * UI column.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterProperties(EloquentBuilder|QueryBuilder|Relation $query, string $value): static
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query->orLike('slug', $value)
                        ->orLike('conditions', $value)
                        ->orLike('description', $value);
            }
        });

        return $this;
    }

    /**
     * Sort based on slug/condition UI column.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $direction
     *
     * @return static
     */
    protected function sortProperties(EloquentBuilder|QueryBuilder|Relation $query, string $direction): static
    {
        $query->orderBy('slug', $direction);

        return $this;
    }
}
