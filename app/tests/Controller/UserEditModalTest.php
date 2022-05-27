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
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Database\Models\Permission;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Admin\Tests\testUserTrait;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class UserEditModalTest extends AdminTestCase
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
        $request = $this->createJsonRequest('GET', '/modals/users/edit');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(302, $response);

        // Assert Event Redirect
        $this->assertSame('/account/sign-in?redirect=%2Fmodals%2Fusers%2Fedit', $response->getHeaderLine('Location'));
    }

    public function testPageForForbiddenException(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: ['create_user']);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/edit')
                        ->withQueryParams(['user_name' => $user->user_name]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testPage(): void
    {
        // Setup custom permissions for group test.
        $permission = new Permission([
            'slug'       => 'update_user_field',
            'name'       => 'update_user_field',
            'conditions' => "subset(fields,['name','email','locale','flag_enabled','flag_verified','password'])",
        ]);
        $permission->save();

        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, permissions: [$permission]);

        /** @var Config */
        $config = $this->ci->get(Config::class);

        // Force locale config.
        $config->set('site.locales.available', ['en_US' => true]);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/modals/users/edit')
                        ->withQueryParams(['user_name' => $user->user_name]);
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
    }

    // public function testPageForOneLocaleAndGroupPermissions(): void
    // {
    //     /** @var User */
    //     $user = User::factory()->create();
    //     $this->actAsUser($user, permissions: ['create_user', 'create_user_field']);

    //     /** @var Config */
    //     $config = $this->ci->get(Config::class);

    //     // Force locale config.
    //     $config->set('site.locales.available', ['en_US' => true]);

    //     // Create request with method and url and fetch response
    //     $request = $this->createJsonRequest('GET', '/modals/users/create');
    //     $response = $this->handleRequest($request);

    //     // Assert response status & body
    //     $this->assertResponseStatus(200, $response);
    //     $this->assertNotEmpty((string) $response->getBody());
    // }
}
