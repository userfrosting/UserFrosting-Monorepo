<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Bakery;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Bakery\RouteListCommand;
use UserFrosting\Sprinkle\Core\Util\RouteList;
use UserFrosting\Testing\BakeryTester;
use UserFrosting\Testing\ContainerStub;

/**
 * Test SeedListCommand
 */
class RouteListCommandTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCommand(): void
    {
        $data = [
            [
                'method' => 'GET',
                'uri'    => '/foo',
                'name'   => '',
                'action' => 'Foo/BarAction',
            ]
        ];

        // Setup Seeds mock
        $routeList = Mockery::mock(RouteList::class)
            ->shouldReceive('get')->once()->andReturn($data)
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(RouteList::class, $routeList);
        $command = $ci->get(RouteListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(0, $result->getStatusCode());
        $this->assertStringContainsString('Registered Routes', $result->getDisplay());
    }

    public function testCommandWithException(): void
    {
        // Setup Seeds mock
        $routeList = Mockery::mock(RouteList::class)
            ->shouldReceive('get')->once()->andThrow(\Exception::class, 'Problem with sort')
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(RouteList::class, $routeList);
        $command = $ci->get(RouteListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Registered Routes', $result->getDisplay());
        $this->assertStringContainsString('Problem with sort', $result->getDisplay());
    }

    public function testCommandWithNoRoutes(): void
    {
        // Setup Seeds mock
        $routeList = Mockery::mock(RouteList::class)
            ->shouldReceive('get')->once()->andReturn([])
            ->getMock();

        // Set mock in CI and run command
        $ci = ContainerStub::create();
        $ci->set(RouteList::class, $routeList);
        $command = $ci->get(RouteListCommand::class);
        $result = BakeryTester::runCommand($command);

        // Assert some output
        $this->assertSame(1, $result->getStatusCode());
        $this->assertStringContainsString('Registered Routes', $result->getDisplay());
        $this->assertStringContainsString('No routes found.', $result->getDisplay());
    }
}
