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
 * This event is dispatched when the user is validated, before login or session is restore.
 * A listener can throw an exception to interrupt the login, session or rememberme restoration process.
 * User can also be mutated by the listener.
 */
class UserValidatedEvent
{
    /**
     * @param UserInterface $user
     */
    public function __construct(public UserInterface $user)
    {
    }
}
