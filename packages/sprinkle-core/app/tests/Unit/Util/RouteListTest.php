<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Util;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Slim\App;
use Slim\Interfaces\RouteCollectorInterface;
use Slim\Routing\Route;
use UserFrosting\Sprinkle\Core\Util\RouteList;
use UserFrosting\Testing\ContainerStub;

/**
 * Test RouteList
 */
class RouteListTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testGet(): void
    {
        // Setup routes mock
        $route1 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->times(2)->andReturn('Foo\BarAction')
            ->shouldReceive('getMethods')->once()->andReturn(['GET'])
            ->shouldReceive('getPattern')->once()->andReturn('/foo')
            ->shouldReceive('getName')->once()->andReturn('')
            ->getMock();

        $route2 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->times(1)->andReturn(function () {
            }) // Callable
            ->shouldReceive('getMethods')->once()->andReturn(['GET', 'POST'])
            ->shouldReceive('getPattern')->once()->andReturn('/bar')
            ->shouldReceive('getName')->once()->andReturn('foobar')
            ->getMock();

        $routeCollector = Mockery::mock(RouteCollectorInterface::class)
            ->shouldReceive('getRoutes')->once()->andReturn([$route1, $route2])
            ->getMock();
        $app = Mockery::mock(App::class)
            ->shouldReceive('getRouteCollector')->once()->andReturn($routeCollector)
            ->getMock();

        // Set mock in CI and get class
        $ci = ContainerStub::create();
        $ci->set(App::class, $app);

        /** @var RouteList */
        $routeList = $ci->get(RouteList::class);

        // Assert some output
        $expected = [
            [
                'method' => 'GET',
                'uri'    => '/foo',
                'name'   => '',
                'action' => 'Foo\BarAction',
            ],
            [
                'method' => 'GET|POST',
                'uri'    => '/bar',
                'name'   => 'foobar',
                'action' => 'Callable',
            ]
        ];
        $this->assertSame($expected, $routeList->get());
    }

    public function testGetWithNoRoutes(): void
    {
        // Setup routes mock
        $routeCollector = Mockery::mock(RouteCollectorInterface::class)
            ->shouldReceive('getRoutes')->once()->andReturn([])
            ->getMock();
        $app = Mockery::mock(App::class)
            ->shouldReceive('getRouteCollector')->once()->andReturn($routeCollector)
            ->getMock();

        // Set mock in CI and get class
        $ci = ContainerStub::create();
        $ci->set(App::class, $app);

        /** @var RouteList */
        $routeList = $ci->get(RouteList::class);

        // Assert some output
        $this->assertSame([], $routeList->get());
    }

    public function testGetWithSort(): void
    {
        // Setup routes mock
        $route1 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn('Foo\BarAction')
            ->shouldReceive('getMethods')->andReturn(['POST'])
            ->shouldReceive('getPattern')->andReturn('/foo')
            ->shouldReceive('getName')->andReturn('foobar')
            ->getMock();

        $route2 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn(function () {
            }) // Callable
            ->shouldReceive('getMethods')->andReturn(['GET'])
            ->shouldReceive('getPattern')->andReturn('/bar')
            ->shouldReceive('getName')->andReturn('')
            ->getMock();

        $routeCollector = Mockery::mock(RouteCollectorInterface::class)
            ->shouldReceive('getRoutes')->andReturn([$route1, $route2])
            ->getMock();
        $app = Mockery::mock(App::class)
            ->shouldReceive('getRouteCollector')->andReturn($routeCollector)
            ->getMock();

        // Set mock in CI and get class
        $ci = ContainerStub::create();
        $ci->set(App::class, $app);

        /** @var RouteList */
        $routeList = $ci->get(RouteList::class);

        // Assert some output
        $expectedRoute1 = [
            'method' => 'POST',
            'uri'    => '/foo',
            'name'   => 'foobar',
            'action' => 'Foo\BarAction',
        ];
        $expectedRoute2 = [
            'method' => 'GET',
            'uri'    => '/bar',
            'name'   => '',
            'action' => 'Callable',
        ];
        $this->assertSame([$expectedRoute1, $expectedRoute2], $routeList->get(sortBy: null));

        // Action
        $this->assertSame([$expectedRoute2, $expectedRoute1], $routeList->get(sortBy: 'acTiOn')); // Test case insensitivity
        $this->assertSame([$expectedRoute1, $expectedRoute2], $routeList->get(sortBy: 'action', reverse: true)); // Test reverse

        // Method
        $this->assertSame([$expectedRoute2, $expectedRoute1], $routeList->get(sortBy: 'method'));

        // uri
        $this->assertSame([$expectedRoute2, $expectedRoute1], $routeList->get(sortBy: 'uri'));

        // name
        $this->assertSame([$expectedRoute2, $expectedRoute1], $routeList->get(sortBy: 'name'));
    }

    public function testGetWithBadSort(): void
    {
        // Setup routes mock
        $route1 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn('Foo\BarAction')
            ->shouldReceive('getMethods')->andReturn(['POST'])
            ->shouldReceive('getPattern')->andReturn('/foo')
            ->shouldReceive('getName')->andReturn('foobar')
            ->getMock();

        $route2 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn(function () {
            }) // Callable
            ->shouldReceive('getMethods')->andReturn(['GET'])
            ->shouldReceive('getPattern')->andReturn('/bar')
            ->shouldReceive('getName')->andReturn('')
            ->getMock();

        $routeCollector = Mockery::mock(RouteCollectorInterface::class)
            ->shouldReceive('getRoutes')->andReturn([$route1, $route2])
            ->getMock();
        $app = Mockery::mock(App::class)
            ->shouldReceive('getRouteCollector')->andReturn($routeCollector)
            ->getMock();

        // Set mock in CI and get class
        $ci = ContainerStub::create();
        $ci->set(App::class, $app);

        /** @var RouteList */
        $routeList = $ci->get(RouteList::class);

        // Assert some output
        $this->expectException(\Exception::class);
        $routeList->get(sortBy: 'foo');
    }

    public function testGetWithFilter(): void
    {
        // Setup routes mock
        $route1 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn('Foo\BarAction')
            ->shouldReceive('getMethods')->andReturn(['POST'])
            ->shouldReceive('getPattern')->andReturn('/foo')
            ->shouldReceive('getName')->andReturn('foobar')
            ->getMock();

        $route2 = Mockery::mock(Route::class)
            ->shouldReceive('getCallable')->andReturn(function () {
            }) // Callable
            ->shouldReceive('getMethods')->andReturn(['GET'])
            ->shouldReceive('getPattern')->andReturn('/bar')
            ->shouldReceive('getName')->andReturn('')
            ->getMock();

        $routeCollector = Mockery::mock(RouteCollectorInterface::class)
            ->shouldReceive('getRoutes')->andReturn([$route1, $route2])
            ->getMock();
        $app = Mockery::mock(App::class)
            ->shouldReceive('getRouteCollector')->andReturn($routeCollector)
            ->getMock();

        // Set mock in CI and get class
        $ci = ContainerStub::create();
        $ci->set(App::class, $app);

        /** @var RouteList */
        $routeList = $ci->get(RouteList::class);

        // Assert some output
        $expectedRoute1 = [
            'method' => 'POST',
            'uri'    => '/foo',
            'name'   => 'foobar',
            'action' => 'Foo\BarAction',
        ];
        $expectedRoute2 = [
            'method' => 'GET',
            'uri'    => '/bar',
            'name'   => '',
            'action' => 'Callable',
        ];

        // Default
        $this->assertSame([$expectedRoute1, $expectedRoute2], $routeList->get());

        // Action
        $this->assertSame([$expectedRoute1], $routeList->get(filterAction: 'BarAction'));
        $this->assertSame([$expectedRoute2], $routeList->get(filterAction: 'Callable'));
        $this->assertSame([$expectedRoute2], $routeList->get(filterAction: 'caLLable')); // Test case insensitivity

        // Method
        $this->assertSame([$expectedRoute2], $routeList->get(filterMethod: 'GET'));
        $this->assertSame([$expectedRoute2], $routeList->get(filterMethod: 'GeT')); // Test case insensitivity

        // uri
        $this->assertSame([$expectedRoute2], $routeList->get(filterUri: 'bar'));
        $this->assertSame([$expectedRoute2], $routeList->get(filterUri: 'BaR')); // Test case insensitivity

        // name
        $this->assertSame([$expectedRoute1], $routeList->get(filterName: 'foobar'));
        $this->assertSame([$expectedRoute1], $routeList->get(filterName: 'FooBar')); // Test case insensitivity
        $this->assertSame([], $routeList->get(filterName: ''));
    }
}
