<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Authorize;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;

/**
 * Manages a collection of access condition callbacks, and uses them to perform
 * access control checks on user objects.
 */
interface AuthorizationManagerInterface
{
    /**
     * Checks whether or not a user has access on a particular permission slug.
     *
     * Determine if this user has access to the given $slug under the given $params.
     *
     * @param UserInterface|null $user
     * @param string             $slug   The permission slug to check for access.
     * @param mixed[]            $params An array of field names => values, specifying any additional data to provide the authorization module
     *                                   when determining whether or not this user has access.
     *
     * @return bool True if the user has access, false otherwise.
     */
    public function checkAccess(?UserInterface $user, string $slug, array $params = []): bool;
}
