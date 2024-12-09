<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Unit\Testing;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Testing\TestCase;
use UserFrosting\Tests\TestSprinkle\TestSprinkle;
use UserFrosting\UserFrosting;

/**
 * Tests the custom `createRequest` part of the TestCase class.
 */
class TestCaseTest extends TestCase
{
    protected string $mainSprinkle = Sprinkle::class;

    public function testProperties(): void
    {
        $this->assertInstanceOf(UserFrosting::class, $this->userfrosting); // @phpstan-ignore-line
        $this->assertInstanceOf(App::class, $this->app); // @phpstan-ignore-line
        $this->assertInstanceOf(ContainerInterface::class, $this->ci); // @phpstan-ignore-line
    }

    /**
     * Make sure a request can be created and handled.
     */
    public function testCreateJsonRequest(): void
    {
        $request = $this->createJsonRequest('POST', '/test');
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);
        $this->assertJsonResponse([], $response);
    }

    /**
     * Make sure a request **with post data** can be created and handled.
     * Also make sure the middleware is applied, and have access to the post
     * data correctly (ie. BodyParsingMiddleware is applied in the correct order).
     */
    public function testCreateJsonRequestWithPost(): void
    {
        $request = $this->createJsonRequest('POST', '/test', ['foo' => 'bar']);
        $response = $this->handleRequest($request);
        $this->assertResponseStatus(200, $response);
        $this->assertJsonResponse(['bar' => 'foo'], $response);
    }
}

class TestRoute implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->post('/test', function (Response $response, Request $request) {
            return $response->withHeader('Content-Type', 'application/json');
        });
    }
}

class TestMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        $post = (array) $request->getParsedBody();
        $payload = json_encode(array_flip($post), JSON_THROW_ON_ERROR);
        $response = $handler->handle($request);
        $response->getBody()->write($payload);

        return $response;
    }
}

class Sprinkle extends TestSprinkle
{
    public function getRoutes(): array
    {
        return [
            TestRoute::class,
        ];
    }

    public function getMiddlewares(): array
    {
        return [
            TestMiddleware::class,
        ];
    }
}
