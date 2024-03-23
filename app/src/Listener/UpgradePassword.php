<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Listener;

use UserFrosting\Sprinkle\Account\Authenticate\Hasher;
use UserFrosting\Sprinkle\Account\Event\UserAuthenticatedEvent;
use UserFrosting\Sprinkle\Account\Log\UserActivityLoggerInterface;
use UserFrosting\Sprinkle\Account\Log\UserActivityTypes;

/**
 * Save the user activity when the user is logged-in.
 */
class UpgradePassword
{
    public function __construct(
        protected Hasher $hasher,
        protected UserActivityLoggerInterface $logger,
    ) {
    }

    public function __invoke(UserAuthenticatedEvent $event): void
    {
        // Update password if we had encountered an outdated hash
        $passwordType = $this->hasher->getHashType($event->user->password);

        if ($passwordType !== 'modern') {
            // Hash the user's password and update
            $event->user->password = $event->getPassword(); // Password hashing will be done in User Model
            $event->user->save(); // Save changes

            // Add a sign in activity (time is automatically set by database)
            $this->logger->debug("User {$event->user->user_name} outdated password hash has been automatically updated to modern hashing.", [
                'type'    => UserActivityTypes::PASSWORD_UPGRADED,
                'user_id' => $event->user->id,
            ]);
        }
    }
}
