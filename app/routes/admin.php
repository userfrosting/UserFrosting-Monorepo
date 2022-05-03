<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

use UserFrosting\Sprinkle\Core\Util\NoCache;

/*
 * Routes for administrative panel management.
 */
$app->group('/dashboard', function () {
    $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\AdminController:pageDashboard')
         ->setName('dashboard');
})->add('authGuard')->add(new NoCache());

$app->group('/api/dashboard', function () {
    $this->post('/clear-cache', 'UserFrosting\Sprinkle\Admin\Controller\AdminController:clearCache');
})->add('authGuard')->add(new NoCache());

$app->group('/modals/dashboard', function () {
    $this->get('/clear-cache', 'UserFrosting\Sprinkle\Admin\Controller\AdminController:getModalConfirmClearCache');
})->add('authGuard')->add(new NoCache());
