<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

/**
 * Entry point for the /public site.
 */

// First off, we'll grab the Composer dependencies
require_once __DIR__ . '/../vendor/autoload.php';

use UserFrosting\Sprinkle\Account\Account;
use UserFrosting\UserFrosting;

$uf = new UserFrosting(Account::class);
$uf->run();
