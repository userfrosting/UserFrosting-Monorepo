<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests;

use UserFrosting\Sprinkle\Admin\Admin;
use UserFrosting\Testing\TestCase;

/**
 * Test case with Admin as main sprinkle
 */
class AdminTestCase extends TestCase
{
    protected string $mainSprinkle = Admin::class;
}
