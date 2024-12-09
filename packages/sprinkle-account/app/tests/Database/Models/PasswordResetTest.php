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

use DateTime;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PasswordResetInterface;
use UserFrosting\Sprinkle\Account\Database\Models\PasswordReset;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * PasswordResetTest Class. Tests the PasswordReset Model.
 */
class PasswordResetTest extends AccountTestCase
{
    use RefreshDatabase;

    /**
     * Setup the database schema.
     */
    public function setUp(): void
    {
        parent::setUp();

        // Setup test database
        $this->refreshDatabase();
    }

    public function testPasswordReset(): void
    {
        // Assert Initial DB state
        $this->assertSame(0, PasswordReset::count());

        /** @var User */
        $user = User::factory()->create();

        $passwordReset = new PasswordReset([
            'hash'  => 'TEST',
        ]);
        $passwordReset->user()->associate($user);
        $passwordReset->save();
        $this->assertInstanceOf(PasswordResetInterface::class, $passwordReset); // @phpstan-ignore-line

        // Assert new state
        $this->assertSame(1, PasswordReset::count());

        // Get Model and assert it's default properties
        /** @var PasswordReset */
        $fetched = PasswordReset::find($passwordReset->id);
        $this->assertSame($user->id, $fetched->user_id);
        $this->assertSame('TEST', $fetched->hash);
        $this->assertFalse($fetched->completed);
        $this->assertNull($fetched->expires_at);
        $this->assertNull($fetched->completed_at);

        // Assert User relations
        $this->assertSame($user->id, $fetched->user?->id);

        // Delete
        $fetched->delete();

        // Assert new state
        $this->assertSame(0, PasswordReset::count());
    }

    public function testDateCasting(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var PasswordReset */
        $passwordReset = PasswordReset::factory()
            ->state([
                'expires_at'   => new DateTime('2022-01-01'),
                'completed_at' => new DateTime('2021-01-01'),
            ])
            ->for($user)
            ->create();

        $this->assertInstanceOf(DateTime::class, $passwordReset->expires_at);
        $this->assertInstanceOf(DateTime::class, $passwordReset->completed_at);
        $this->assertSame('2022-01-01', $passwordReset->expires_at->format('Y-m-d'));
        $this->assertSame('2021-01-01', $passwordReset->completed_at->format('Y-m-d'));
    }

    public function testTokenAccessor(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var PasswordReset */
        $passwordReset = PasswordReset::factory()->for($user)->create();

        $token = 'foobar';
        $this->assertSame($token, $passwordReset->setToken($token)->getToken());
    }

    public function testUserRelation(): void
    {
        /** @var User */
        $user = User::factory()->create();

        PasswordReset::factory()->count(3)->for($user)->create();

        $this->assertSame(3, $user->passwordResets()->count());
        $this->assertContainsOnlyInstancesOf(PasswordResetInterface::class, $user->passwordResets); // @phpstan-ignore-line

        // Test force deletion and cascade deletion
        $user->forceDelete();
        $this->assertSame(0, PasswordReset::count());
    }
}
