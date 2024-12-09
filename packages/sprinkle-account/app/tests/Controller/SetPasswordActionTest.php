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

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Repository\PasswordResetRepository;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class SetPasswordActionTest extends AccountTestCase
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

    public function testSetPassword(): void
    {
        /** @var User */
        $user = User::factory()->create();

        // Create fake PasswordResetRepository
        /** @var PasswordResetRepository */
        $repoPasswordReset = $this->ci->get(PasswordResetRepository::class);
        $resetModel = $repoPasswordReset->create($user, 9999);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/set-password', [
            'password'  => 'testSetPassword',
            'passwordc' => 'testSetPassword',
            'token'     => $resetModel->getToken(),
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponse('', $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
    }

    public function testSetPasswordWithNoToken(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/set-password', [
            'password'  => 'testSetPassword',
            'passwordc' => 'testSetPassword',
            'token'     => 'potato',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Invalid Password Reset Token', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }

    public function testSetPasswordWithFailedValidation(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/set-password');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Validation error', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }
}
