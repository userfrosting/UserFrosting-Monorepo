<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;
use UserFrosting\Sprinkle\Core\Throttle\ThrottlerDelayException;

/**
 * Tests ThrottlerDelayException class.
 */
class ThrottlerDelayExceptionTest extends TestCase
{
    protected string $mainSprinkle = SprinkleStub::class;

    public function testFakeRouteJson(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/test');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(429, $response);
        $this->assertJsonResponse([
            'title'       => 'Rate Limit Exceeded',
            'description' => 'The rate limit for this action has been exceeded. You must wait another 123 seconds before you will be allowed to make another attempt.',
            'status'      => 429,
        ], $response);
    }

    public function testFakeRoute(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/test');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(429, $response);
    }
}

class SprinkleStub extends Core
{
    public function getRoutes(): array
    {
        return [
            TestRoutes::class,
        ];
    }
}

class TestRoutes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->get('/test', function () {
            $e = new ThrottlerDelayException();
            $e->setDelay(123);

            throw $e;
        });
    }
}
