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

use Illuminate\Database\Connection;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Tests\AdminTestCase;
use UserFrosting\Sprinkle\Admin\Tests\testUserTrait;
use UserFrosting\Sprinkle\Core\Testing\RefreshDatabase;

class DashboardActionTest extends AdminTestCase
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

    public function testPageDashboardForGuestUser(): void
    {
        // Create request with method and url and fetch response
        $this->actAsUser(null);
        $request = $this->createJsonRequest('GET', '/dashboard');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Login Required', $response, 'title');
        $this->assertResponseStatus(302, $response);

        // Assert Event Redirect
        $this->assertSame('/account/sign-in?redirect=%2Fdashboard', $response->getHeaderLine('Location'));
    }

    public function testPageDashboardForForbiddenException(): void
    {
        /** @var User */
        $user = User::factory()->make();
        $this->actAsUser($user, permissions: ['uri_dashboard' => false]);

        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/dashboard');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse('Access Denied', $response, 'title');
        $this->assertResponseStatus(403, $response);
    }

    public function testPageDashboard(): void
    {
        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/dashboard');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
    }

    public function testPageDashboardWithPDOException(): void
    {
        // Mock PDO
        $pdo = Mockery::mock(\PDO::class)
            ->shouldReceive('getAttribute')->with(\PDO::ATTR_DRIVER_NAME)->andThrow(new \PDOException())
            ->shouldReceive('getAttribute')->with(\PDO::ATTR_SERVER_VERSION)->andThrow(new \PDOException())
            ->getMock();
        $connection = Mockery::mock(Connection::class)
            ->shouldReceive('getDatabaseName')->andReturn('database name')
            ->shouldReceive('getPdo')->andReturn($pdo)
            ->getMock();
        $this->ci->set(Connection::class, $connection);

        /** @var User */
        $user = User::factory()->create();
        $this->actAsUser($user, isMaster: true);

        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/dashboard');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(200, $response);
        $this->assertNotEmpty((string) $response->getBody());
    }
}
