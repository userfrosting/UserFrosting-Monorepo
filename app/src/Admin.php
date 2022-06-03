<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin;

use UserFrosting\Event\EventListenerRecipe;
use UserFrosting\Sprinkle\Account\Account;
use UserFrosting\Sprinkle\Account\Event\UserRedirectedAfterLoginEvent;
use UserFrosting\Sprinkle\Admin\Listener\UserRedirectedToDashboard;
use UserFrosting\Sprinkle\Admin\Listener\UserRedirectedToSettings;
use UserFrosting\Sprinkle\Admin\Routes\ActivitiesRoutes;
use UserFrosting\Sprinkle\Admin\Routes\DashboardRoutes;
use UserFrosting\Sprinkle\Admin\Routes\GroupsRoute;
use UserFrosting\Sprinkle\Admin\Routes\PermissionsRoutes;
use UserFrosting\Sprinkle\Admin\Routes\RolesRoutes;
use UserFrosting\Sprinkle\Admin\Routes\UsersRoutes;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\SprinkleRecipe;
use UserFrosting\Theme\AdminLTE\AdminLTE;

class Admin implements SprinkleRecipe, EventListenerRecipe
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Admin Sprinkle';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return __DIR__ . '/../';
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function getBakeryCommands(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getSprinkles(): array
    {
        return [
            Core::class,
            Account::class,
            AdminLTE::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getRoutes(): array
    {
        return [
            ActivitiesRoutes::class,
            DashboardRoutes::class,
            GroupsRoute::class,
            PermissionsRoutes::class,
            RolesRoutes::class,
            UsersRoutes::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getServices(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getMiddlewares(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     * N.B.: Last listeners will be executed first.
     */
    public function getEventListeners(): array
    {
        return [
            UserRedirectedAfterLoginEvent::class => [
                UserRedirectedToSettings::class,
                UserRedirectedToDashboard::class,
            ],
        ];
    }
}
