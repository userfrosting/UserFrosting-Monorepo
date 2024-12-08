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

use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultRoles;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * DefaultRoles Seed Test.
 */
class DefaultRolesTest extends AccountTestCase
{
    use RefreshDatabase;

    public function testSeed(): void
    {
        // Setup fresh, empty table
        $this->refreshDatabase();

        // Assert initial table state
        $this->assertCount(0, Role::all());

        // Apply seed
        $seed = new DefaultRoles();
        $seed->run();

        // Assert new table state
        $this->assertCount(3, Role::all());
    }
}
