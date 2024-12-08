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
 * This event is dispatched when the user is authenticated.
 * A listener can throw an exception to interrupt the authentication/login process.
 * User can also be mutated by the listener.
 */
class UserAuthenticatedEvent
{
    /**
     * @param UserInterface $user
     * @param string        $identityColumn
     * @param string|int    $identityValue
     * @param string        $password
     */
    public function __construct(
        public UserInterface $user,
        protected string $identityColumn,
        protected string|int $identityValue,
        protected string $password,
    ) {
    }

    /**
     * Get the value of identityColumn.
     */
    public function getIdentityColumn(): string
    {
        return $this->identityColumn;
    }

    /**
     * Get the value of identityValue.
     */
    public function getIdentityValue(): string|int
    {
        return $this->identityValue;
    }

    /**
     * Get the value of password.
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}
