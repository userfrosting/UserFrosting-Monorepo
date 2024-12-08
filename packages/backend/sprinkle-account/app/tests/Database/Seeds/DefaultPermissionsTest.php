<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Database\Models;

use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultPermissions;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * DefaultPermissions Seed Test.
 */
class DefaultPermissionsTest extends AccountTestCase
{
    use RefreshDatabase;

    public function testSeed(): void
    {
        // Setup fresh, empty table
        $this->refreshDatabase();

        /** @var Permission */
        $permission = $this->ci->get(Permission::class);

        // Assert initial table state
        $this->assertCount(0, $permission::all());

        // Apply seed
        $seed = new DefaultPermissions();
        $seed->run();

        // Assert new table state
        $this->assertCount(33, Permission::all());

        // Test running again
        $seed->run();
        $this->assertCount(33, Permission::all());
    }
}
