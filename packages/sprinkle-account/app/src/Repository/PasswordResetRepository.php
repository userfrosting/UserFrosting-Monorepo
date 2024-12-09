<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Repository;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PasswordResetInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Facades\Password;
use UserFrosting\Sprinkle\Account\Log\UserActivityLoggerInterface;
use UserFrosting\Sprinkle\Account\Log\UserActivityTypes;

/**
 * Token repository class for password reset requests.
 *
 * @extends TokenRepository<PasswordResetInterface>
 */
class PasswordResetRepository extends TokenRepository
{
    /**
     * Inject Dependencies.
     *
     * @param PasswordResetInterface      $modelIdentifier
     * @param UserActivityLoggerInterface $logger
     */
    public function __construct(
        protected PasswordResetInterface $modelIdentifier,
        protected UserActivityLoggerInterface $logger,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelIdentifier(): PasswordResetInterface
    {
        return $this->modelIdentifier;
    }

    /**
     * {@inheritdoc}
     */
    protected function updateUser(UserInterface $user, array $args): void
    {
        $user->setPasswordAttribute(strval($args['password']));

        // Create activity record
        $this->logger->info("User {$user->user_name} reset it's password.", [
            'type'    => UserActivityTypes::PASSWORD_RESET,
            'user_id' => $user->id,
        ]);

        $user->save();
    }
}
