<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\TestSprinkle;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TestController
{
    public function index(Request $request, Response $response, MessageGenerator $messageGenerator, Container $container): Response
    {
        // Prep data container
        $msg = [];

        /** @var MessageGenerator */
        $service = $container->get('testMessageGenerator');

        // Message from service
        $msg[] = $service->getMessage();

        // Message from DI Injection
        $msg[] = $messageGenerator->getMessage();

        // Message from Middleware
        $msg[] = $request->getAttribute('foo');

        // Add both messages to body
        $payload = json_encode($msg, JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response;
    }
}
