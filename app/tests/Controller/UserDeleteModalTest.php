<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Controller;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Admin\Tests\testUserTrait;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class UserDeleteModalTest extends AdminTestCase
{
    use RefreshDatabase;
    use testUserTrait;
    use MockeryPHPUnitIntegration;

    /**
     * Setup test database for controller tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testPageForGuestUser(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/confirm-delete');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(302, $response);

        // Assert Event Redirect
        $this->assertSame('/account/sign-in?redirect=%2Fmodals%2Fusers%2Fconfirm-delete', $response->getHeaderLine('Location'));
    }

    public function testPageWithNoUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/confirm-delete');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'title'       => 'Validation error',
            'description' => 'Please specify a value for <strong>Username</strong>.',
            'status'      => 400,
        ], $response);
        $this->assertResponseStatus(400, $response);
    }

    public function testPageForNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create a second user, to be deleted.
        /** @var User */
        $userToDelete = User::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/confirm-delete')
                        ->withQueryParams(['user_name' => $userToDelete->user_name]);
        // $request->set
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testPage(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['delete_user']);

        // Create a second user, to be deleted.
        /** @var User */
        $userToDelete = User::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/confirm-delete')
                        ->withQueryParams(['user_name' => $userToDelete->user_name]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
    }
}
