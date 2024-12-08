<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Exceptions;

use Slim\App as SlimApp;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Exceptions\UserFacingException;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;

/**
 * Test the handler for UserFacingException.
 */
class UserFacingExceptionTest extends TestCase
{
    protected string $mainSprinkle = UserFacingExceptionTestSprinkle::class;

    public function testHTML(): void
    {
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $ms->resetMessageStream();

        // Create request with method and url and fetch response
        $request = $this->createRequest('GET', '/UserFacingException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(400, $response);

        // Test message
        $messages = $ms->getAndClearMessages();
        $this->assertCount(1, $messages);
        $this->assertSame('danger', end($messages)['type']); // @phpstan-ignore-line
    }

    public function testJson(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/UserFacingException');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertResponseStatus(400, $response);
        $this->assertJsonResponse([
            'title'       => 'Foo',
            'description' => 'Bar',
            'status'      => 400
        ], $response);

        // Test message
        /** @var AlertStream */
        $ms = $this->ci->get(AlertStream::class);
        $messages = $ms->getAndClearMessages();
        $this->assertCount(1, $messages);
        $this->assertSame('danger', end($messages)['type']); // @phpstan-ignore-line
    }
}

class UserFacingExceptionTestRoutes implements RouteDefinitionInterface
{
    public function register(SlimApp $app): void
    {
        $app->get('/UserFacingException', function () {
            $e = new UserFacingException();
            $e->setTitle('Foo');
            $e->setDescription('Bar');
            throw $e;
        });
    }
}

class UserFacingExceptionTestSprinkle extends Core
{
    public function getRoutes(): array
    {
        return [
            UserFacingExceptionTestRoutes::class,
        ];
    }
}
