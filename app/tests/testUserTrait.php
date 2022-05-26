<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests;

use UserFrosting\Config\Config;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Models\Role;

/**
 * TODO : Leave this here for now, to test it out. Move to Account later :)
 */
trait testUserTrait
{
    /**
     * Set user for tests.
     *
     * @param UserInterface|null $user
     * @param bool               $isMaster If true, will set user as master user (permission for everything).
     * @param RoleInterface[]    $roles
     * @param (PermissionInterface|string)[] $permissions Permission will be added through a new empty role.
     */
    protected function actAsUser(
        UserInterface $user,
        bool $isMaster = false,
        array $roles = [],
        array $permissions = []
    ): void {

        /** @var Config */
        $config = $this->ci->get(Config::class);
        $masterId = ($isMaster) ? $user->id : 0;
        $config->set('reserved_user_ids.master', $masterId);

        /** @var Authenticator */
        $authenticator = $this->ci->get(Authenticator::class);
        $authenticator->login($user);

        // Assign roles
        foreach ($roles as $role) {
            $user->roles()->attach($role);
            $user->save();
        }

        // Assign permissions
        if (count($permissions) !== 0) {
            $role = Role::factory()->create();
            $user->roles()->attach($role);

            foreach ($permissions as $permission) {
                if (is_string($permission)) {
                    $permission = new Permission([
                        'slug'       => $permission,
                        'name'       => $permission,
                        'conditions' => 'always()',
                    ]);
                    $permission->save();
                }
                $role->permissions()->attach($permission);
                $role->save();
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function createApplication(): void
    {
        parent::createApplication();

        // Make sure we have a session
        $session = $this->ci->get(Session::class);
        $session->start();
    }

    /**
     * {@inheritDoc}
     */
    protected function deleteApplication(): void
    {
        // Make sure to clean up the session before we delete the application.
        $session = $this->ci->get(Session::class);
        $session->destroy();

        parent::deleteApplication();
    }
}
