<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Repository;

use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Database\Models\Verification;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

/**
 * Tests VerificationRepository. Also test abstract TokenRepository.
 */
class VerificationRepositoryTest extends AccountTestCase
{
    use RefreshDatabase;

    /**
     * Setup the test database.
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testCreate(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        // User don't have token by default
        $this->assertFalse($repo->exists($user));

        // Create
        $model = $repo->create($user, 3600);
        $this->assertInstanceOf(Verification::class, $model);

        // User does have a token now, just not any one.
        $this->assertTrue($repo->exists($user));
        $this->assertFalse($repo->exists($user, 'blah'));
    }

    public function testComplete(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $verification = $repo->create($user, 3600);
        $this->assertTrue($repo->exists($user));
        $this->assertTrue($repo->validate($verification->getToken()));
        $this->assertTrue($repo->complete($verification->getToken()));
        $this->assertFalse($repo->exists($user));
        $this->assertFalse($repo->validate($verification->getToken()));
    }

    public function testCompleteWithUserGone(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $verification = $repo->create($user, 3600);

        // Hack user is deleted in case of
        $user->delete();

        $this->assertFalse($repo->complete($verification->getToken()));
    }

    public function testCancel(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $verification = $repo->create($user, 3600);
        $this->assertTrue($repo->exists($user));
        $this->assertTrue($repo->cancel($verification->getToken()));
        $this->assertFalse($repo->exists($user));
    }

    public function testBadToken(): void
    {
        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $this->assertFalse($repo->cancel('foo'));
        $this->assertFalse($repo->complete('foo'));
    }

    public function testExpired(): void
    {
        /** @var User */
        $user = User::factory()->create();

        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $repo->create($user, -3600);
        $this->assertSame(1, Verification::count());
        $this->assertSame(1, $repo->removeExpired());
        $this->assertSame(0, Verification::count());
    }

    public function testGetSetAlgorithm(): void
    {
        /** @var VerificationRepository */
        $repo = $this->ci->get(VerificationRepository::class);

        $this->assertSame('foo', $repo->setAlgorithm('foo')->getAlgorithm());
    }
}
