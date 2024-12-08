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
use Psr\EventDispatcher\EventDispatcherInterface;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Account\Repository\VerificationRepository;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;

class DenyResetPasswordActionTest extends AccountTestCase
{
    use MockeryPHPUnitIntegration;

    public function testDenyResetPassword(): void
    {
        // Mock PasswordResetRepository
        $repoPasswordReset = Mockery::mock(PasswordResetRepository::class)
            ->shouldReceive('cancel')->once()->with('potato')->andReturn(true)
            ->getMock();
        $this->ci->set(PasswordResetRepository::class, $repoPasswordReset);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/set-password/deny')
            ->withQueryParams(['token' => 'potato']);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
    }

    public function testDenyResetPasswordWithRedirect(): void
    {
        // Mock eventDispatcher
        $eventDispatcher = Mockery::mock(EventDispatcherInterface::class)
            ->shouldReceive('dispatch')->once()->andReturn(new UserRedirectedAfterDRPTestEvent())
            ->getMock();
        $this->ci->set(EventDispatcherInterface::class, $eventDispatcher);

        // Mock PasswordResetRepository
        $repoPasswordReset = Mockery::mock(PasswordResetRepository::class)
            ->shouldReceive('cancel')->once()->with('potato')->andReturn(true)
            ->getMock();
        $this->ci->set(PasswordResetRepository::class, $repoPasswordReset);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/set-password/deny')
            ->withQueryParams(['token' => 'potato']);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(302, $response);
        $this->assertSame('/home', $response->getHeaderLine('Location'));
    }

    public function testDenyResetPasswordWithFailedPasswordReset(): void
    {
        // Mock PasswordResetRepository
        $repoPasswordReset = Mockery::mock(PasswordResetRepository::class)
            ->shouldReceive('cancel')->once()->with('potato')->andReturn(false)
            ->getMock();
        $this->ci->set(PasswordResetRepository::class, $repoPasswordReset);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/set-password/deny')
            ->withQueryParams(['token' => 'potato']);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', array_reverse($messages)[0]['type']);
    }

    public function testDenyResetPasswordWithFailedValidation(): void
    {
        // Mock VerificationRepository
        $repoVerification = Mockery::mock(VerificationRepository::class)
            ->shouldNotReceive('cancel')
            ->getMock();
        $this->ci->set(VerificationRepository::class, $repoVerification);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/account/set-password/deny');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', array_reverse($messages)[0]['type']);
    }
}

class UserRedirectedAfterDRPTestEvent
{
    public function getRedirect(): ?string
    {
        return '/home';
    }
}
