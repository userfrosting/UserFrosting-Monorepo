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
use UserFrosting\Sprinkle\Core\Error\Renderer\HtmlRenderer;
use UserFrosting\Sprinkle\Core\Tests\Unit\Error\TestException;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use UserFrosting\Testing\CustomAssertionsTrait;

/**
 * HtmlRenderer Test
 *
 * WARNING : This test validates the appropriates dependencies are called the
 * code doesn't throws any errors. The actual output is not truly tested.
 */
class HtmlRendererTest extends TestCase
{
    use MockeryPHPUnitIntegration;
    use CustomAssertionsTrait;

    public function testRenderRequest(): void
    {
        // Mocks
        $uri = Mockery::mock(UriInterface::class);
        $request = Mockery::mock(Request::class)
            ->shouldReceive('getMethod')->once()->andReturn('GET')
            ->shouldReceive('getUri')->once()->andReturn($uri)
            ->shouldReceive('getQueryParams')->once()->andReturn([])
            ->shouldReceive('getHeaders')->once()->andReturn(['FOO' => 'bar'])
            ->getMock();

        // Create renderer and render request
        $renderer = new HtmlRenderer();
        $html = $renderer->renderRequest($request);

        // Assert
        $this->assertHtmlTagCount(3, $html, 'h3');
    }

    public function testRenderException(): void
    {
        // Create renderer and render exception
        $renderer = new HtmlRenderer();
        $html = $renderer->renderException(new TestException());

        // Assert
        $this->assertNotSame('', $html);
    }

    public function testRender(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new HtmlRenderer();
        $html = $renderer->render(
            request: $request,
            exception: new TestException(),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: false
        );

        // Assert
        $this->assertNotSame('', $html);
        $this->assertHtmlTagCount(1, $html, 'html');
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
        $renderer = new HtmlRenderer();
        $html = $renderer->render(
            request: $request,
            exception: new TestException('test message', 456, new TestException()),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: true
        );

        // Assert
        $this->assertNotSame('', $html);
        $this->assertHtmlTagCount(1, $html, 'html');
    }
}
