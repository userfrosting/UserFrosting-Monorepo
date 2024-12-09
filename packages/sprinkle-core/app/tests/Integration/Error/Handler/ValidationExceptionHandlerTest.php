<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Error\Handler;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\Validator\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Routes\RouteDefinitionInterface;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase;

/**
 * Tests ValidationExceptionHandler
 */
class ValidationExceptionHandlerTest extends CoreTestCase
{
    protected string $mainSprinkle = SprinkleStub::class;

    public function testRegisterWithFailedValidation(): void
    {
        // Create request with method and url and fetch response
        $request = $this->createJsonRequest('GET', '/test');
        $response = $this->handleRequest($request);

        // Assert response status & body
        $this->assertJsonResponse([
            'title'       => 'Validation error',
            'description' => 'Invalid email address.',
            'status'      => 400,
        ], $response);
        $this->assertResponseStatus(400, $response);
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
        $app->get('/test', function (Request $request, Response $response, Translator $translator) {
            $schema = new RequestSchema([
                'email' => [
                    'validators' => [
                        'email' => [
                            'message' => 'VALIDATE.INVALID_EMAIL'
                        ],
                    ],
                ],
            ]);

            $validator = new ServerSideValidator($translator);
            $error = $validator->validate($schema, [
                'email' => 'david',
            ]);
            $e = new ValidationException();
            $e->addErrors($error);

            throw $e;
        });
    }
}
