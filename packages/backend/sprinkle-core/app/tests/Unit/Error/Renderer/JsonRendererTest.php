<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Error\Renderer;

use Exception;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Request;
use UserFrosting\Sprinkle\Core\Error\Renderer\JsonRenderer;
use UserFrosting\Sprinkle\Core\Tests\Unit\Error\TestException;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use UserFrosting\Testing\CustomAssertionsTrait;

/**
 * JsonRenderer Test
 */
class JsonRendererTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    use CustomAssertionsTrait;

    public function testRenderException(): void
    {
        // Create renderer and render exception
        $renderer = new JsonRenderer();
        $data = $renderer->formatExceptionFragment(new TestException());

        // Assert
        $this->assertSame(TestException::class, $data['type']);
        $this->assertSame(123, $data['code']);
        $this->assertSame('Test exception', $data['message']);
        $this->assertIsString($data['file']);
        $this->assertIsInt($data['line']);
    }

    public function testRender(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new JsonRenderer();
        $json = $renderer->render(
            request: $request,
            exception: new TestException(),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: false
        );

        // Assert
        $this->assertJsonEquals([
            'title'       => 'title',
            'description' => 'description',
            'status'      => 234,
        ], $json);
    }

    public function testRenderWithDisplayErrorDetail(): void
    {
        // Mocks
        $uri = Mockery::mock(UriInterface::class);
        $request = Mockery::mock(Request::class)
            ->shouldReceive('getMethod')->once()->andReturn('GET')
            ->shouldReceive('getUri')->once()->andReturn($uri)
            ->shouldReceive('getQueryParams')->once()->andReturn([])
            ->shouldReceive('getHeaders')->once()->andReturn(['FOO' => 'bar'])
            ->getMock();
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new JsonRenderer();
        $json = $renderer->render(
            request: $request,
            exception: new TestException('test message', 456, new TestException()),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: true
        );

        // Assert
        $this->assertJsonStructure(['title', 'description', 'status', 'request', 'trace', 'exception'], $json);
        $this->assertJsonEquals('title', $json, 'title');
        $this->assertJsonEquals('description', $json, 'description');
        $this->assertJsonEquals(234, $json, 'status');
        $this->assertJsonCount(2, $json, 'exception');
        $this->assertJsonStructure(['method', 'uri', 'params', 'headers'], $json, 'request');

        // Assert Exception structure
        $this->assertJsonStructure(['type', 'code', 'message', 'file', 'line'], $json, 'exception.0');
        $this->assertJsonEquals(TestException::class, $json, 'exception.0.type');
        $this->assertJsonEquals(456, $json, 'exception.0.code');
        $this->assertJsonEquals('test message', $json, 'exception.0.message');
    }
}
