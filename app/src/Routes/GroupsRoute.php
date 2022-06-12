<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Routes;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Account\Authenticate\AuthGuard;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupCreateAction;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupCreateModal;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupDeleteAction;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupDeleteModal;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupPageAction;
use UserFrosting\Sprinkle\Admin\Controller\Group\GroupsPageAction;

/*
 * Routes for administrative group management.
 */
class GroupsRoute implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->group('/groups', function (RouteCollectorProxy $group) {
            $group->get('', GroupsPageAction::class)->setName('uri_groups');
            $group->get('/g/{slug}', GroupPageAction::class);
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/api/groups', function (RouteCollectorProxy $group) {
            $group->delete('/g/{slug}', GroupDeleteAction::class);
            $group->get('', [GroupsPageAction::class, 'sprunje']);
            // $group->get('/g/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\GroupController:getInfo');
            // $group->get('/g/{slug}/users', 'UserFrosting\Sprinkle\Admin\Controller\GroupController:getUsers');
            $group->post('', GroupCreateAction::class);
            // $group->put('/g/{slug}', 'UserFrosting\Sprinkle\Admin\Controller\GroupController:updateInfo');
        })->add(AuthGuard::class); //->add(new NoCache());

        $app->group('/modals/groups', function (RouteCollectorProxy $group) {
            $group->get('/confirm-delete', GroupDeleteModal::class)->setName('modal.group.delete');
            $group->get('/create', GroupCreateModal::class)->setName('modal.group.create');
            // $group->get('/edit', 'UserFrosting\Sprinkle\Admin\Controller\GroupController:getModalEdit');
        })->add(AuthGuard::class); //->add(new NoCache());
    }
}
