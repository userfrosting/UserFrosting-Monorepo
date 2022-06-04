<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Controller\User;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Admin\Tests\testUserTrait;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class UserUpdateFieldActionTest extends AdminTestCase
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
        $request = $this->createJsonRequest('PUT', '/api/users/u/foo/password');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(302, $response);

        // Assert Event Redirect
        $this->assertSame('/account/sign-in?redirect=%2Fapi%2Fusers%2Fu%2Ffoo%2Fpassword', $response->getHeaderLine('Location'));
    }

    public function testPageWithNotFoundUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('PUT', '/api/users/u/foo/password');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'title'       => 'Account Not Found',
            'description' => 'This account does not exist. It may have been deleted.',
            'status'      => 400,
        ], $response);
        $this->assertResponseStatus(400, $response);
    }

    public function testPostForNoData(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/password');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Validation error', $response, 'title');
        $this->assertJsonResponse('Please specify a value for <strong>password</strong>.', $response, 'description');
        $this->assertResponseStatus(400, $response);
    }

    public function testPageForNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create a second user, to be edited.
        /** @var User */
        $userToEdit = User::factory()->create();

        // Create request with method and url and fetch response
        $data = ['password' => 'newpassword'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/password', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testPostForPassword(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create a second user, to be edited.
        /** @var User */
        $userToEdit = User::factory()->create();

        // Create request with method and url and fetch response
        $data = [
            'password'  => 'newpassword',
            'passwordc' => 'newpassword',
        ];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/password', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
        $this->assertSame('Account details updated for user <strong>' . $userToEdit->user_name . '</strong>', array_reverse($messages)[0]['message']);
    }

    public function testPostForPasswordWithoutConfirmation(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create a second user, to be edited.
        /** @var User */
        $userToEdit = User::factory()->create();

        // Create request with method and url and fetch response
        $data = [
            'password'  => 'newpassword',
            'passwordc' => 'notnewpassword',
        ];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/password', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Your password and confirmation password must match.', $response, 'description');
        $this->assertResponseStatus(400, $response);
    }

    public function testPostForEnabled(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create request with method and url and fetch response
        $data = ['flag_enabled' => '1'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/flag_enabled', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
        $this->assertSame('Account for user <strong>' . $user->user_name . '</strong> has been successfully enabled.', array_reverse($messages)[0]['message']);
    }

    public function testPostForDisabled(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create a second user, to be edited.
        /** @var User */
        $userToEdit = User::factory()->create();

        // Create request with method and url and fetch response
        $data = ['flag_enabled' => '0'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/flag_enabled', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
        $this->assertSame('Account for user <strong>' . $userToEdit->user_name . '</strong> has been successfully disabled.', array_reverse($messages)[0]['message']);
    }

    public function testPostForVerified(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create request with method and url and fetch response
        $data = ['flag_verified' => '1'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/flag_verified', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
        $this->assertSame($user->user_name . "'s account has been manually activated", array_reverse($messages)[0]['message']);
    }

    public function testPostForRole(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        /** @var Role */
        $roles = Role::factory()->count(2)->create();

        // Create request with method and url and fetch response
        $data = ['roles' => $roles->toArray()];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/roles', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([], $response);
        $this->assertResponseStatus(200, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
        $this->assertSame('Account details updated for user <strong>' . $user->user_name . '</strong>', array_reverse($messages)[0]['message']);
    }

    public function testPageForFailedValidation(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create a second user, to be edited.
        /** @var User */
        $userToEdit = User::factory()->create();

        // Create request with method and url and fetch response
        $data = ['email' => 'notAndEmail'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/email', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Invalid email address.', $response, 'description');
        $this->assertResponseStatus(400, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', array_reverse($messages)[0]['type']);
    }

    public function testPageForFailedToEditMasterUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create a second user, and set it to master.
        /** @var User */
        $userToEdit = User::factory()->create();

        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('reserved_user_ids.master', $userToEdit->id);

        // Create request with method and url and fetch response
        $data = ['email' => 'notAndEmail'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $userToEdit->user_name . '/email', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('danger', array_reverse($messages)[0]['type']);
    }

    public function testPostForDisableMasterUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create request with method and url and fetch response
        $data = ['flag_enabled' => '0'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/flag_enabled', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('You cannot disable the master account', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }

    public function testPostForDisableSameUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['update_user_field']);

        // Create request with method and url and fetch response
        $data = ['flag_enabled' => '0'];
        $request = $this->createJsonRequest('PUT', '/api/users/u/' . $user->user_name . '/flag_enabled', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('You cannot disable your own account', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }
}
