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
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * Implements Sprunje for the users API.
 */
class UserSprunje extends Sprunje
{
    protected string $name = 'users';

    protected array $listable = [
        'status',
    ];

    protected array $sortable = [
        'name',
        'last_activity',
        'status',
    ];

    protected array $filterable = [
        'name',
        'last_activity',
        'status',
    ];

    protected array $excludeForAll = [
        'last_activity',
    ];

    public function __construct(
        protected UserInterface $userModel,
        protected Translator $translator,
    ) {
        parent::__construct();
    }

    /**
     * Join user's most recent activity
     * {@inheritdoc}
     */
    protected function baseQuery(): EloquentBuilder|QueryBuilder|Relation|Model
    {
        // @phpstan-ignore-next-line Activity interface mixin Model and non-static method.
        return $this->userModel->joinLastActivity();
    }

    /**
     * Filter LIKE the last activity description.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterLastActivity(EloquentBuilder|QueryBuilder|Relation $query, string $value): static
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query->orLike('activities.description', $value);
            }
        });

        return $this;
    }

    /**
     * Filter LIKE the first name, last name, or email.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterName(EloquentBuilder|QueryBuilder|Relation $query, string $value): static
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query->orLike('first_name', $value)
                        ->orLike('last_name', $value)
                        ->orLike('email', $value);
            }
        });

        return $this;
    }

    /**
     * Filter by status (active, disabled, unactivated).
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $value
     *
     * @return static
     */
    protected function filterStatus(EloquentBuilder|QueryBuilder|Relation $query, string $value): static
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);
        $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                if ($value == 'disabled') {
                    $query->orWhere('flag_enabled', 0);
                } elseif ($value == 'unactivated') {
                    $query->orWhere('flag_verified', 0);
                } elseif ($value == 'active') {
                    $query->orWhere(function ($query) {
                        $query->where('flag_enabled', 1)->where('flag_verified', 1);
                    });
                }
            }
        });

        return $this;
    }

    /**
     * Return a list of possible user statuses.
     *
     * @return array{value: string, text: string}[]
     */
    protected function listStatus(): array
    {
        return [
            [
                'value' => 'active',
                'text'  => $this->translator->translate('ACTIVE'),
            ],
            [
                'value' => 'unactivated',
                'text'  => $this->translator->translate('UNACTIVATED'),
            ],
            [
                'value' => 'disabled',
                'text'  => $this->translator->translate('DISABLED'),
            ],
        ];
    }

    /**
     * Sort based on last activity time.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $direction
     *
     * @return static
     */
    protected function sortLastActivity(EloquentBuilder|QueryBuilder|Relation $query, string $direction): static
    {
        $query->orderBy('activities.occurred_at', $direction);

        return $this;
    }

    /**
     * Sort based on last name.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $direction
     *
     * @return static
     */
    protected function sortName(EloquentBuilder|QueryBuilder|Relation $query, string $direction): static
    {
        $query->orderBy('last_name', $direction);

        return $this;
    }

    /**
     * Sort active, unactivated, disabled.
     *
     * @param EloquentBuilder|QueryBuilder|Relation $query
     * @param string                                $direction
     *
     * @return static
     */
    protected function sortStatus(EloquentBuilder|QueryBuilder|Relation $query, string $direction): static
    {
        $query->orderBy('flag_enabled', $direction)->orderBy('flag_verified', $direction);

        return $this;
    }
}
