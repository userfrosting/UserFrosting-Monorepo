<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use UserFrosting\Sprinkle\Core\Database\Relations\Concerns\Unique;

/**
 * A BelongsToMany relationship that reduces the related members to a unique (by primary key) set.
 *
 * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Database/Eloquent/Relations/BelongsToMany.php
 */
class BelongsToManyUnique extends BelongsToMany
{
    use Unique;
}
