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
 * Routes for administrative activity monitoring.
 */
$app->group('/activities', function () {
    $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\ActivityController:pageList')
        ->setName('uri_activities');
})->add('authGuard')->add(new NoCache());

$app->group('/api/activities', function () {
    $this->get('', 'UserFrosting\Sprinkle\Admin\Controller\ActivityController:getList');
})->add('authGuard')->add(new NoCache());
