<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

/**
 * Entry point for the /public site.
 */

// First off, we'll grab the Composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';

use UserFrosting\Sprinkle\Admin\Admin;
use UserFrosting\UserFrosting;

$uf = new UserFrosting(Admin::class);
$uf->run();
