<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Controller\User;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Group;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Core\Mail\Mailer;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class UserCreateActionTest extends AdminTestCase
{
    use RefreshDatabase;
    use WithTestUser;
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
        $request = $this->createJsonRequest('POST', '/api/users');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }

    public function testPageForForbiddenException(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testPost(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldReceive('send')->once()
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'locale'     => 'en_US',
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertJsonStructure([
            'success',
            'message',
            'user',
        ], $response);
        $this->assertJsonResponse(true, $response, 'success');
        $this->assertJsonResponse('User <strong>foo</strong> has been successfully created', $response, 'message');
        $this->assertJsonResponse('Foo', $response, 'user.first_name');

        // Make sure the user is added to the db by querying it
        /** @var User */
        $user = User::where('email', 'foo@bar.com')->first();
        $this->assertSame('foo', $user['user_name']);
        $this->assertSame('en_US', $user['locale']);
    }

    /**
     * @depends testPost
     */
    public function testPostWithPassword(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldNotReceive('send')
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'password'   => 'password1',
            'passwordc'  => 'password1',
            'locale'     => 'en_US',
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertJsonStructure([
            'success',
            'message',
            'user',
        ], $response);
        $this->assertJsonResponse(true, $response, 'success');
        $this->assertJsonResponse('User <strong>foo</strong> has been successfully created', $response, 'message');
        $this->assertJsonResponse('Foo', $response, 'user.first_name');

        // Make sure the user is added to the db by querying it
        /** @var User */
        $user = User::where('email', 'foo@bar.com')->first();
        $this->assertSame('foo', $user['user_name']);
        $this->assertSame('en_US', $user['locale']);
    }

    /**
     * @depends testPost
     */
    public function testPostWithPasswordAndFailedPasswordValidation(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldNotReceive('send')
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'password'   => 'password1',
            'passwordc'  => 'password2', // TODO : This should fail
            'locale'     => 'en_US',
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Your password and confirmation password must match.', $response, 'description');
        $this->assertResponseStatus(400, $response);
    }

    /**
     * @depends testPost
     */
    public function testPostForFailedGroup(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'locale'     => 'en_US',
            'group_id'   => 1, // User group does not exist anyway
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(403, $response);
        $this->assertJsonResponse('Access Denied', $response, 'title');
    }

    /**
     * @depends testPost
     */
    public function testPostForGroup(): void
    {
        /** @var Group */
        $group = Group::factory()->create();

        /** @var User */
        $user = User::factory()->for($group)->create();
        $this->actAsUser($user, permissions: ['create_user']);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldReceive('send')->once()
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'group_id'   => $group->id,
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertJsonStructure([
            'success',
            'message',
            'user',
        ], $response);
        $this->assertJsonResponse($group->id, $response, 'user.group_id');

        // Make sure the user is added to the db by querying it
        /** @var User */
        $user = User::where('email', 'foo@bar.com')->first();
        $this->assertSame($group->id, $user->group?->id);
        $this->assertSame('en_US', $user['locale']); // Locale will be default :)
    }

    /**
     * When a Group Administrator without the create_user_field permission
     * creates a new user, the new user SHOULD inherit the admin's group.
     * Same as previous test, however, `group_id` is not set in the data payload.
     *
     * @see https://github.com/userfrosting/UserFrosting/issues/1256
     */
    public function testPostForGroupIsSetAs(): void
    {
        /** @var Group */
        $group = Group::factory()->create();

        /** @var User */
        $user = User::factory()->for($group)->create();
        $this->actAsUser($user, permissions: ['create_user']);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldReceive('send')->once()
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertJsonResponse(true, $response, 'success');

        // Make sure the user is added to the db by querying it
        /** @var User */
        $user = User::where('email', 'foo@bar.com')->first();
        $this->assertSame($group->id, $user->group?->id);
        $this->assertSame('en_US', $user['locale']); // Locale will be default :)
    }

    public function testPostForNoGroup(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', ['en_US' => true]);

        /** @var Mailer */
        $mailer = Mockery::mock(Mailer::class)
            ->makePartial()
            ->shouldReceive('send')->once()
            ->getMock();
        $this->ci->set(Mailer::class, $mailer);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'locale'     => 'en_US',
            'group_id'   => 0,
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertJsonResponse(true, $response, 'success');

        // Make sure the user is added to the db by querying it
        /** @var User */
        $user = User::where('email', 'foo@bar.com')->first();
        $this->assertSame('foo', $user['user_name']);
        $this->assertSame('en_US', $user['locale']);
    }

    /**
     * @depends testPost
     */
    public function testPostForFailedValidation(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo', // <-- Bad Email on purpose
            'locale'     => 'en_US',
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(400, $response);
        $this->assertJsonResponse([
            'title'       => 'Validation error',
            'description' => 'Invalid email address.',
            'status'      => 400,
        ], $response);
    }

    /**
     * @depends testPost
     */
    public function testPostForInvalidLocale(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.registration.user_defaults.locale', 'en_US');
        $config->set('site.locales.available', [
            'en_US' => true,
            'en_GB' => true,
        ]);

        // Set post payload
        $data = [
            'user_name'  => 'foo',
            'first_name' => 'Foo',
            'last_name'  => 'Bar',
            'email'      => 'foo@bar.com',
            'locale'     => 'fr_FR', // <-- Invalid locale on purpose
        ];

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/api/users', $data);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'title'       => 'Account Exception',
            'description' => 'fr_FR is not a valid locale.',
            'status'      => 400,
        ], $response);
        $this->assertResponseStatus(400, $response);
    }
}
