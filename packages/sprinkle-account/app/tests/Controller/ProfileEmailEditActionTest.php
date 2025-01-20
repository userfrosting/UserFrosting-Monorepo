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

use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Account\Tests\AccountTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class ProfileEmailEditActionTest extends AccountTestCase
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

    public function testSettings(): void
    {
        /** @var User */
        $user = User::factory(['password' => 'potato'])->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/email', [
            'passwordcheck' => 'potato',
            'email'         => 'testSettings@test.com',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'message' => 'Account settings updated',
        ], $response);
        $this->assertResponseStatus(200, $response);

        // Refresh user, make sure password was hashed, and it actually changed.
        /** @var User */
        $freshUser = User::find($user->id);
        $this->assertSame('testSettings@test.com', $freshUser->email);
    }

    public function testSettingsWithNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user); // No permissions !

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/email');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testSettingsWithFailedValidation(): void
    {
        /** @var User */
        $user = User::factory(['password' => 'potato'])->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/email');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Validation error', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }

    public function testSettingsWithFailedPasswordCheck(): void
    {
        /** @var User */
        $user = User::factory(['password' => 'potato'])->create();
        $this->actAsUser($user, true);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/email', [
            'passwordcheck' => 'foo', //<-- Not potato
            'email'         => 'testSettings@test.com',
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Account Exception', $response, 'title');
        $this->assertJsonResponse("Current password doesn't match the one we have on record", $response, 'description');
        $this->assertResponseStatus(400, $response);
    }

    public function testSettingsWithEmailInUse(): void
    {
        /** @var User */
        $user = User::factory(['password' => 'potato'])->create();
        $this->actAsUser($user, true);

        /** @var User */
        $firstUser = User::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('POST', '/account/settings/email', [
            'passwordcheck' => 'potato',
            'email'         => $firstUser->email,
        ]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Invalid email', $response, 'title');
        $this->assertResponseStatus(400, $response);
    }
}
