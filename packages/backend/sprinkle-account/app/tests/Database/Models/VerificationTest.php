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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\VerificationInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Database\Models\Verification;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * VerificationTest Class. Tests the Verification Model.
 */
class VerificationTest extends AccountTestCase
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

    public function testVerification(): void
    {
        // Assert Initial DB state
        $this->assertSame(0, Verification::count());

        /** @var User */
        $user = User::factory()->create();

        $verification = new Verification([
            'hash'  => 'TEST',
        ]);
        $verification->user()->associate($user);
        $verification->save();
        $this->assertInstanceOf(VerificationInterface::class, $verification); // @phpstan-ignore-line

        // Assert new state
        $this->assertSame(1, Verification::count());

        // Get Model and assert it's default properties
        /** @var Verification */
        $fetched = Verification::find($verification->id);
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
        $this->assertSame(0, Verification::count());
    }

    public function testDateCasting(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var Verification */
        $verification = Verification::factory()
            ->state([
                'expires_at'   => new DateTime('2022-01-01'),
                'completed_at' => new DateTime('2021-01-01'),
            ])
            ->for($user)
            ->create();

        $this->assertInstanceOf(DateTime::class, $verification->expires_at);
        $this->assertInstanceOf(DateTime::class, $verification->completed_at);
        $this->assertSame('2022-01-01', $verification->expires_at->format('Y-m-d'));
        $this->assertSame('2021-01-01', $verification->completed_at->format('Y-m-d'));
    }

    public function testTokenAccessor(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var Verification */
        $Verification = Verification::factory()->for($user)->create();

        $token = 'foobar';
        $this->assertSame($token, $Verification->setToken($token)->getToken());
    }

    public function testUserRelation(): void
    {
        /** @var User */
        $user = User::factory()->create();

        Verification::factory()->count(3)->for($user)->create();

        $this->assertSame(3, $user->verifications()->count());
        $this->assertContainsOnlyInstancesOf(VerificationInterface::class, $user->verifications); // @phpstan-ignore-line

        // Test force deletion and cascade deletion
        $user->forceDelete();
        $this->assertSame(0, Verification::count());
    }
}
