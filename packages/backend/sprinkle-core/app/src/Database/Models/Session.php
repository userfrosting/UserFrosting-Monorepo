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

use UserFrosting\Sprinkle\Core\Database\Models\Interfaces\SessionModelInterface;

/**
 * Session Class.
 *
 * Represents a session object as stored in the database.
 *
 * @mixin \Illuminate\Database\Query\Builder
 */
class Session extends Model implements SessionModelInterface
{
    /**
     * @var string The name of the table for the current model.
     */
    protected $table = 'sessions';

    /**
     * @var bool Disable timestamps
     */
    public $timestamps = false;
}
