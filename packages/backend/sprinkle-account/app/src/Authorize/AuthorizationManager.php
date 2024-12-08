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

use Illuminate\Support\Arr;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Log\AuthLoggerInterface;

/**
 * Manages a collection of access condition callbacks, and uses them to perform
 * access control checks on user objects.
 */
class AuthorizationManager implements AuthorizationManagerInterface
{
    /**
     * Create a new AuthorizationManager object.
     *
     * @param Config                   $config
     * @param AuthLoggerInterface      $logger
     * @param AccessConditionEvaluator $ace
     */
    public function __construct(
        protected Config $config,
        protected AuthLoggerInterface $logger,
        protected AccessConditionEvaluator $ace,
    ) {
    }

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
    public function checkAccess(?UserInterface $user, string $slug, array $params = []): bool
    {
        $debug = $this->config->getBool('debug.auth', false);

        if ($user === null) {
            if ($debug) {
                $this->logger->debug('No user defined. Access denied.');
            }

            return false;
        }

        if ($debug) {
            $trace = array_slice(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3), 1);
            $this->logger->debug('Authorization check requested at: ', $trace);
            $this->logger->debug("Checking authorization for user {$user->id} ('{$user->user_name}') on permission '$slug'...");
        }

        // The master (root) account has access to everything.
        // Need to use loose comparison for now, because some DBs return `id` as a string.
        if ($user->id === $this->config->getInt('reserved_user_ids.master')) {
            if ($debug) {
                $this->logger->debug('User is the master (root) user. Access granted.');
            }

            return true;
        }

        // Find all permissions that apply to this user (via roles), and check if any evaluate to true.
        $permissions = $user->getCachedPermissions();

        if (count($permissions) === 0 || !isset($permissions[$slug])) {
            if ($debug) {
                $this->logger->debug('No matching permissions found. Access denied.');
            }

            return false;
        }

        $permissions = $permissions[$slug];

        if ($debug) {
            $this->logger->debug("Found matching permissions: \n" . print_r($this->getPermissionsArrayDebugInfo($permissions), true));
        }

        foreach ($permissions as $permission) {
            $pass = $this->ace->evaluate($permission->conditions, $params, $user);
            if ($pass) {
                if ($debug) {
                    $this->logger->debug("User passed conditions '{$permission->conditions}'. Access granted.");
                }

                return true;
            }
        }

        if ($debug) {
            $this->logger->debug('User failed to pass any of the matched permissions. Access denied.');
        }

        return false;
    }

    /**
     * Remove extraneous information from the permission to reduce verbosity.
     *
     * @param array<string, \UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface> $permissions
     *
     * @return array<array<string, string>>
     */
    protected function getPermissionsArrayDebugInfo(array $permissions): array
    {
        $permissionsInfo = [];
        foreach ($permissions as $permission) {
            $permissionData = Arr::only($permission->toArray(), ['id', 'slug', 'name', 'conditions', 'description']);
            // Remove this until we can find an efficient way to only load these once during debugging
            //$permissionData['roles_via'] = $permission->roles_via->pluck('id')->all();
            $permissionsInfo[] = $permissionData;
        }

        return $permissionsInfo;
    }
}
