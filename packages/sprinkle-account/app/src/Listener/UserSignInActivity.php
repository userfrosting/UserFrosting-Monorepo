<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Listener;

use UserFrosting\Sprinkle\Account\Event\UserLoggedInEvent;
use UserFrosting\Sprinkle\Account\Log\UserActivityLoggerInterface;
use UserFrosting\Sprinkle\Account\Log\UserActivityTypes;

/**
 * Save the user activity when the user is logged-in.
 */
class UserSignInActivity
{
    public function __construct(
        protected UserActivityLoggerInterface $logger,
    ) {
    }

    public function __invoke(UserLoggedInEvent $event): void
    {
        // Add a sign in activity (time is automatically set by database)
        $this->logger->info("User {$event->user->user_name} signed in.", [
            'type'    => UserActivityTypes::LOGGED_IN,
            'user_id' => $event->user->id,
        ]);
    }
}
