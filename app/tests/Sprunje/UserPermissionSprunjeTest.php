<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Sprunje;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Sprunje\UserPermissionSprunje;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * Tests a UserPermissionSprunje.
 */
class UserPermissionSprunjeTest extends AdminTestCase
{
    use RefreshDatabase;

    protected UserInterface $user;
    protected RoleInterface $role;
    protected EloquentCollection $permissions;

    public function setUp(): void
    {
        parent::setUp();

        // Set database up.
        $this->refreshDatabase();
        $this->createData();
    }

    protected function createData(): void
    {
        // @phpstan-ignore-next-line
        $this->permissions = Permission::factory()
                        ->count(3)
                        ->sequence(fn ($sequence) => ['slug' => 'name_' . $sequence->index])
                        ->create();

        /** @var Role */
        $role = Role::factory()->create();
        $role->permissions()->attach($this->permissions);
        $role->save();
        $this->role = $role;

        /** @var User */
        $user = User::factory()->create();
        $user->roles()->attach($role);
        $user->save();
        $this->user = $user;
    }

    public function testBaseSprunje(): void
    {
        $sprunje = new UserPermissionSprunje($this->user);
        $data = $sprunje->getArray();

        $this->assertEquals(3, $data['count']);
        $this->assertEquals(3, $data['count_filtered']);
        $this->assertCount(3, $data['rows']); // @phpstan-ignore-line
    }

    public function testWithInfoFilter(): void
    {
        $sprunje = new UserPermissionSprunje($this->user);
        $sprunje->setOptions([
            'filters' => ['info' => 'name_1'],
        ]);
        $data = $sprunje->getArray();

        $this->assertEquals(3, $data['count']);
        $this->assertEquals(1, $data['count_filtered']);
        $this->assertCount(1, $data['rows']); // @phpstan-ignore-line
    }

    public function testForSortProperties(): void
    {
        $sprunje = new UserPermissionSprunje($this->user);
        $sprunje->setOptions([
            'sorts' => ['properties' => 'desc'],
        ]);
        $data = $sprunje->getArray();

        $this->assertEquals(3, $data['count']);
        $this->assertEquals(3, $data['count_filtered']);
        $this->assertCount(3, $data['rows']); // @phpstan-ignore-line
        $this->assertEquals($this->permissions[2]->id, $data['rows'][0]['id']); // @phpstan-ignore-line
        $this->assertEquals($this->permissions[1]->id, $data['rows'][1]['id']); // @phpstan-ignore-line
        $this->assertEquals($this->permissions[0]->id, $data['rows'][2]['id']); // @phpstan-ignore-line

        $sprunje->setOptions([
            'sorts' => ['properties' => 'asc'],
        ]);
        $data = $sprunje->getArray();
        $this->assertEquals($this->permissions[0]->id, $data['rows'][0]['id']); // @phpstan-ignore-line
        $this->assertEquals($this->permissions[1]->id, $data['rows'][1]['id']); // @phpstan-ignore-line
        $this->assertEquals($this->permissions[2]->id, $data['rows'][2]['id']); // @phpstan-ignore-line
    }
}
