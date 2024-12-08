<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Authorize;

use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authorize\AccessConditions;
use UserFrosting\Sprinkle\Account\Database\Models\Group;
use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class AccessConditionsTest extends AccountTestCase
{
    use MockeryPHPUnitIntegration;
    use RefreshDatabase;

    /** @var Config|\Mockery\MockInterface */
    protected Config $config;

    /**
     * Set mock dependencies.
     * Don't setup application, will be done only when necessary.
     */
    public function setUp(): void
    {
        $this->config = Mockery::mock(Config::class);
    }

    public function testArrayAccess(): void
    {
        $callbacks = new AccessConditions($this->config);

        $this->assertTrue(isset($callbacks['always']));
        $this->assertIsCallable($callbacks['always']); // @phpstan-ignore-line

        $result = call_user_func_array($callbacks['always'], []);
        $this->assertTrue($result);
    }

    public function testArrayAccessExceptionForSet(): void
    {
        $callback = new AccessConditions($this->config);
        $this->expectException(Exception::class);
        $callback['always'] = function () {
            return true;
        };
    }

    public function testArrayAccessExceptionForUnset(): void
    {
        $callback = new AccessConditions($this->config);
        $this->expectException(Exception::class);
        unset($callback['always']);
    }

    public function testAlways(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->always());
    }

    public function testNever(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertFalse($callbacks->never());
    }

    public function testEquals(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->equals(1, 1));
        $this->assertFalse($callbacks->equals(1, 2));
    }

    public function testEqualsNum(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->equals_num(1, 1));
        $this->assertFalse($callbacks->equals_num(1, 2));
        $this->assertTrue($callbacks->equals_num('1', '1'));
        $this->assertFalse($callbacks->equals_num('one', 'one'));
    }

    public function testHasRole(): void
    {
        // Setup test database
        $this->createApplication();
        $this->refreshDatabase();

        /** @var Role */
        $role1 = Role::factory()->create();

        /** @var Role */
        $role2 = Role::factory()->create();

        /** @var User */
        $user1 = User::factory()->create();

        /** @var User */
        $user2 = User::factory()->create();

        // Set relationships
        $user1->roles()->attach($role1);
        $user2->roles()->attach($role1);
        $user2->roles()->attach($role2);

        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->has_role($user1, $role1));
        $this->assertTrue($callbacks->has_role($user1->id, $role1->id));
        $this->assertTrue($callbacks->has_role($user2->id, $role1->id));
        $this->assertTrue($callbacks->has_role($user2->id, $role2->id));
        $this->assertFalse($callbacks->has_role($user1->id, $role2->id));
    }

    public function testHasRoleForUnknownUser(): void
    {
        // Setup test database
        $this->createApplication();
        $this->refreshDatabase();

        $callbacks = new AccessConditions($this->config);
        $this->assertFalse($callbacks->has_role(1, 1));
    }

    public function testIn(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->in(1, [1, 2, 3]));
        $this->assertFalse($callbacks->in(1, [2, 3]));
    }

    public function testInGroup(): void
    {
        // Setup test database
        $this->createApplication();
        $this->refreshDatabase();

        // Create a group
        /** @var Group */
        $group = Group::factory()->create();

        // Create a user
        /** @var User */
        $user = User::factory([
            'group_id' => $group->id,
        ])->create();

        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->in_group($user, $group));
        $this->assertTrue($callbacks->in_group($user->id, $group->id));
        $this->assertFalse($callbacks->in_group($user->id, $group->id + 1));
    }

    public function testInGroupForUnknownUser(): void
    {
        // Setup test database
        $this->createApplication();
        $this->refreshDatabase();

        $callbacks = new AccessConditions($this->config);
        $this->assertFalse($callbacks->in_group(1, 1));
    }

    public function testIsMaster(): void
    {
        $this->config->shouldReceive('get')
                     ->with('reserved_user_ids.master')
                     ->times(3)
                     ->andReturn(1);

        /** @var User */
        $user = User::factory(['id' => 1])->make();

        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->is_master(1));
        $this->assertTrue($callbacks->is_master($user));
        $this->assertFalse($callbacks->is_master(2));
    }

    public function testSubset(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->subset([1, 2, 3], [1, 2, 3, 4]));
        $this->assertFalse($callbacks->subset([1, 2, 3], [1, 2]));
    }

    public function testSubsetKeys(): void
    {
        $callbacks = new AccessConditions($this->config);
        $this->assertTrue($callbacks->subset_keys(['a' => 1, 'b' => 2], ['a', 'b']));
        $this->assertFalse($callbacks->subset_keys(['a' => 1, 'b' => 2], ['a']));
    }
}
