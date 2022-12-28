<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Tests\Controller\Role;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Group;
use UserFrosting\Sprinkle\Account\Database\Models\Role;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Testing\WithTestUser;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class RoleDeleteModalTest extends AdminTestCase
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
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(302, $response);

        // Assert Event Redirect
        $this->assertSame('/account/sign-in?redirect=%2Fmodals%2Froles%2Fconfirm-delete', $response->getHeaderLine('Location'));
    }

    public function testPageWithNoUser(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'title'       => 'Not Found',
            'description' => 'Role not found',
            'status'      => 404,
        ], $response);
        $this->assertResponseStatus(404, $response);
    }

    public function testPageForNoPermissions(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user);

        // Create a group, to be deleted.
        /** @var Role */
        $role = Role::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete')
                        ->withQueryParams(['slug' => $role->slug]);
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
        $this->actAsUser($user, permissions: ['delete_role']);

        // Create a group, to be deleted.
        /** @var Role */
        $role = Role::factory()->create();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete')
                        ->withQueryParams(['slug' => $role->slug]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
    }

    public function testPageForNonEmpty(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create a group, to be deleted.
        /** @var Role */
        $role = Role::factory()->create();

        // Assign user to group
        $user->roles()->attach($role);
        $user->save();

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete')
                        ->withQueryParams(['slug' => $role->slug]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse("You can't do that because there are still users who have the role <strong>{$role->name}</strong>.", $response, 'description');
        $this->assertResponseStatus(400, $response);
    }

    public function testPageForDefault(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create a group, to be deleted.
        /** @var Role */
        $role = Role::factory()->create();

        // Set role as default
        /** @var Config */
        $config = $this->ci->get(Config::class);
        $config->set('site.registration.user_defaults.roles', [$role->slug => true]);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/roles/confirm-delete')
                        ->withQueryParams(['slug' => $role->slug]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse("You can't delete the role <strong>{$role->name}</strong> because it is a default role for newly registered users.", $response, 'description');
        $this->assertResponseStatus(400, $response);
    }
}
