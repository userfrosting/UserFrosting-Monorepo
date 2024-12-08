<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Middlewares\Injector;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\App as SlimApp;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Middlewares\Injector\AbstractInjector;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;

class AbstractInjectorTest extends TestCase
{
    protected string $mainSprinkle = TestSprinkle::class;

    public function testInjector(): void
    {
        $request = $this->createRequest('GET', '/bar/BarFoo');
        $response = $this->handleRequest($request);
        $this->assertResponse('BarFoo', $response);
        $this->assertResponseStatus(200, $response);
    }

    public function testCustomInjector(): void
    {
        $request = $this->createRequest('GET', '/foo')
                        ->withQueryParams(['custom' => 'FooBar']);
        $response = $this->handleRequest($request);
        $this->assertResponse('FooBar', $response);
        $this->assertResponseStatus(200, $response);
    }
}

// Test injector, using default placeholder & attribute name
class TestInjector extends AbstractInjector
{
    protected function getInstance(?string $slug): TestModel
    {
        $model = new TestModel();
        $model->slug = $slug;

        return $model;
    }
}

// Test injector, using a custom placeholder & attribute name
class TestInjectorCustom extends TestInjector
{
    // Route placeholder
    protected string $placeholder = 'custom';

    // Middleware attribute name.
    protected string $attribute = 'throttle';
}

// Test routes
class TestRoutes implements RouteDefinitionInterface
{
    public function register(SlimApp $app): void
    {
        // Test route with slug placeholder, registering TestInjector
        $app->get('/bar/{slug}', function (TestModel $model, Response $response) {
            $response->getBody()->write($model->slug); // @phpstan-ignore-line

            return $response;
        })->add(TestInjector::class);

        // Test route without slug placeholder, registering TestInjectorCustom
        $app->get('/foo', function (TestModel $throttle, Response $response) {
            $response->getBody()->write($throttle->slug); // @phpstan-ignore-line

            return $response;
        })->add(TestInjectorCustom::class);
    }
}

// Test Sprinkle to add our test route
class TestSprinkle extends Core
{
    public function getRoutes(): array
    {
        return [
            TestRoutes::class,
        ];
    }
}

// Test model
class TestModel
{
    public ?string $slug;
}
