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

use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Event\UserCreatedEvent;

class AssignDefaultRoles
{
    public function __construct(
        protected Config $config,
        protected RoleInterface $roleModel,
    ) {
    }

    public function __invoke(UserCreatedEvent $event): void
    {
        // TODO : Default role should be defined in the DB instead of config.
        $defaultRolesSlug = $this->config->get('site.registration.user_defaults.roles');
        $defaultRolesSlug = array_map('trim', array_keys($defaultRolesSlug, true, true)); // @phpstan-ignore-line False positive on array_map

        $defaultRoles = $this->roleModel->whereIn('slug', $defaultRolesSlug)->get();
        $defaultRoleIds = $defaultRoles->pluck('id')->all();

        // Attach default roles
        $event->user->roles()->attach($defaultRoleIds);
    }
}
