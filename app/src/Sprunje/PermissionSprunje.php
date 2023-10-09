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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * Implements Sprunje for the permissions API.
 */
class PermissionSprunje extends Sprunje
{
    protected string $name = 'permissions';

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

    public function __construct(
        protected PermissionInterface $model,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery()
    {
        // @phpstan-ignore-next-line Model implement Model.
        return $this->model;
    }

    /**
     * Filter LIKE the slug, conditions, or description.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterInfo($query, string $value): static
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
    protected function filterProperties($query, string $value): static
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
    protected function sortProperties($query, string $direction): static
    {
        $query->orderBy('slug', $direction);

        return $this;
    }
}
