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

use UserFrosting\Sprinkle\Core\Database\Models\Interfaces\ThrottleModelInterface;

/**
 * Throttle Class.
 *
 * Represents a throttleable request from a user agent.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Throttle extends Model implements ThrottleModelInterface
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'throttles';

    /**
     * @var array<int, string> The attributes that are mass assignable.
     */
    protected $fillable = [
        'type',
        'ip',
        'request_data',
    ];
}
