<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Controller;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;

class ResendVerificationActionTest extends AccountTestCase
{
    use RefreshDatabase;
    use MockeryPHPUnitIntegration;

    /**
     * Setup test database for controller tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testResendVerification(): void
    {
        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldReceive('send')->once()
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        /** @var User */
        $user = User::factory(['flag_verified' => false])->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/resend-verification', [
            'email' => $user->email,
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonStructure(['message'], $response);
        $this->assertResponseStatus(200, $response);
    }

    public function testResendVerificationWithVerifiedUser(): void
    {
        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldNotReceive('send')
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        /** @var User */
        $user = User::factory(['flag_verified' => true])->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/resend-verification', [
            'email' => $user->email,
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonStructure(['message'], $response);
        $this->assertResponseStatus(200, $response);
    }

    public function testResendVerificationWithFailedThrottle(): void
    {
        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldNotReceive('send')
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        /** @var User */
        $user = User::factory(['flag_verified' => true])->create();

        // Create fake throttler
        $throttler = Mockery::mock(Throttler::class)
            ->shouldReceive('getDelay')->once()->with('verification_request', ['email' => $user->email])->andReturn(90)
            ->getMock();
        $this->ci->set(Throttler::class, $throttler);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/resend-verification', [
            'email' => $user->email,
        ]);
        $response = $this->handleRequest($request);

        // Assert response status
        $this->assertResponseStatus(429, $response);
    }

    public function testResendVerificationWithFailedValidation(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/resend-verification');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(400, $response);
    }
}
