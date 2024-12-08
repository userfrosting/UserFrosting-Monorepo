<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Event;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;

/**
 * This event is dispatched when the user is logged in. A listener can throw an
 * exception, and while the exception will interrupt the process, but since this
 * is dispatched after session is setup, a refresh will keep the user logged in.
 * User CANNOT also be mutated by the listener.
 */
class UserLoggedInEvent
{
    /**
     * @param UserInterface $user
     */
    public function __construct(public UserInterface $user)
    {
    }
}
