<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Database\Models\Interfaces;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Query\Builder as QueryBuilder;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Activity Model Interface.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \UserFrosting\Sprinkle\Core\Database\Models\Model
 *
 * @property int           $id
 * @property string|null   $ip_address
 * @property int           $user_id
 * @property string        $type
 * @property Datetime|null $occurred_at
 * @property string        $description
 * @property UserInterface $user
 *
 * @method        $this joinUser()
 * @method static $this joinUser()
 */
interface ActivityInterface
{
    /**
     * Users which belong to this activity.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo;

    /**
     * Scope a query to only include specific type.
     *
     * @param Builder $query
     *
     * @return Builder|QueryBuilder
     */
    public function scopeForType(Builder $query, string $type): Builder|QueryBuilder;

    /**
     * Joins the activity's user, so we can do things like sort, search, paginate, etc. in the Sprunje.
     *
     * @param Builder $query
     *
     * @return Builder|QueryBuilder
     */
    public function scopeJoinUser(Builder $query): Builder|QueryBuilder;
}
