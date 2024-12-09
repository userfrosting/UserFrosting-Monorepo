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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use UserFrosting\Sprinkle\Account\Repository\TokenAccessor;
use UserFrosting\Sprinkle\Core\Database\Models\Model;

/**
 * Verification Model Interface.
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \UserFrosting\Sprinkle\Core\Database\Models\Model
 *
 * @property int                $id
 * @property int                $user_id
 * @property hash               $token
 * @property string             $hash
 * @property bool               $completed
 * @property DateTime|null      $expires_at
 * @property DateTime|null      $completed_at
 * @property UserInterface|null $user
 */
interface VerificationInterface extends TokenAccessor
{
    /**
     * User associated with this verification request.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo;
}
