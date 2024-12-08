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

use UserFrosting\Alert\AlertStream;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class ProfileActionTest extends AccountTestCase
{
    use RefreshDatabase;
    use WithTestUser;

    /**
     * Setup test database for controller tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testProfile(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/profile', [
            'first_name' => 'foo',
            //'last_name'  => 'bar', // don't change this one
            'locale'     => 'en_US',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponse('', $response);
        $this->assertResponseStatus(200, $response);

        // Make sure user was update
        /** @var User */
        $editedUser = User::where('user_name', $user->user_name)->first();
        $this->assertSame('foo', $editedUser->first_name);
        $this->assertSame($user->last_name, $editedUser->last_name);
        $this->assertSame($user->locale, $editedUser->locale);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertSame('success', array_reverse($messages)[0]['type']);
    }

    public function testProfileWithNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user); // No permissions !

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/profile');
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

    public function testProfileWithOneLocale(): void
    {
        /** @var User */
        $user = User::factory(['locale' => 'fr_FR'])->create();
        $this->actAsUser($user, permissions: ['update_account_settings']); // Assert specific permission while at it

        // Force locale config
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.locales.default', 'fr_FR');
        $config->set('site.locales.available', [
            'fr_FR' => true,
        ]);
        $this->ci->set(Config::class, $config);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/profile', [
            'first_name' => 'foo',
            'locale'     => 'es_ES',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);

        // Make sure user was update
        /** @var User */
        $editedUser = User::where('user_name', $user->user_name)->first();
        $this->assertSame('fr_FR', $editedUser->locale);
    }

    public function testProfileWithFailedValidation(): void
    {
        /** @var User */
        $user = User::factory(['password' => 'potato'])->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/profile');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Validation error', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }

    public function testProfileWithInvalidLocale(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/profile', [
            'first_name' => 'foobarfoo',
            'locale'     => 'foobarfoo',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('foobarfoo is not a valid locale.', $response, 'description');
        $this->assertResponseStatus(400, $response);

        // Make sure user was NOT updated
        /** @var User */
        $editedUser = User::where('user_name', $user->user_name)->first();
        $this->assertNotSame('foobarfoo', $editedUser->first_name);
        $this->assertSame($user->first_name, $editedUser->first_name);
        $this->assertSame($user->last_name, $editedUser->last_name);
        $this->assertSame($user->locale, $editedUser->locale);
    }
}
