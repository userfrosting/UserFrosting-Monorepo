<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Testing;

use DI\Container;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Slim\App;
use Slim\Psr7\Factory\ServerRequestFactory;
use UserFrosting\UserFrosting;

/**
 * Case for test that requires the full App instance.
 * This can be used for HTTP testing against the real deal.
 */
class TestCase extends BaseTestCase
{
    use CustomAssertionsTrait;

    /**
     * The global container object, which holds all services.
     */
    protected Container $ci;

    /**
     * The Slim App Instance.
     *
     * @var App<\DI\Container>
     */
    protected App $app;

    /**
     * The UF app instance.
     */
    protected UserFrosting $userfrosting;

    /**
     * String reference to SprinkleRecipe.
     *
     * @var class-string<\UserFrosting\Sprinkle\SprinkleRecipe>
     */
    protected string $mainSprinkle;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->createApplication();
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->deleteApplication();
    }

    /**
     * Create the application instance by setting up a basic UF app.
     */
    protected function createApplication(): void
    {
        $this->userfrosting = new UserFrosting($this->mainSprinkle);
        $this->app = $this->userfrosting->getApp();
        $this->ci = $this->userfrosting->getContainer();
    }

    /**
     * Unset the application instances (UF, Slim App and Container).
     */
    protected function deleteApplication(): void
    {
        unset($this->userfrosting);
        unset($this->app);
        unset($this->ci);
    }

    /**
     * Create a server request.
     *
     * @param string              $method       The HTTP method
     * @param string|UriInterface $uri          The URI
     * @param mixed[]             $serverParams The server parameters
     *
     * @return ServerRequestInterface
     */
    protected function createRequest(
        string $method,
        string|UriInterface $uri,
        array $serverParams = []
    ): ServerRequestInterface {
        $request = new ServerRequestFactory();

        return $request->createServerRequest($method, $uri, $serverParams);
    }

    /**
     * Create a JSON request.
     *
     * @param string              $method The HTTP method
     * @param string|UriInterface $uri    The URI
     * @param mixed[]|null        $data   The json / POST data
     *
     * @return ServerRequestInterface
     */
    protected function createJsonRequest(
        string $method,
        string|UriInterface $uri,
        ?array $data = null
    ): ServerRequestInterface {
        $request = $this->createRequest($method, $uri);

        if (is_array($data)) {
            $request->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        }

        return $request->withHeader('Accept', 'application/json')
                       ->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle request and returns the response.
     *
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    protected function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        return $this->app->handle($request);
    }
}
