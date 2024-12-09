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
use Slim\Psr7\Request;
use UserFrosting\Sprinkle\Core\Error\Renderer\PlainTextRenderer;
use UserFrosting\Sprinkle\Core\Tests\Unit\Error\TestException;
use UserFrosting\Sprinkle\Core\Util\Message\Message;

/**
 * PlainTextRenderer Test
 *
 * WARNING : This test validates the appropriates dependencies are called the
 * code doesn't throws any errors. The actual output is not fully tested.
 */
class PlainTextRendererTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRenderException(): void
    {
        $renderer = new PlainTextRenderer();
        $data = $renderer->formatExceptionFragment(new TestException());

        // Assert
        $this->assertStringContainsString('TestException', $data);
        $this->assertStringContainsString('Code: 123', $data);
        $this->assertStringContainsString('Test exception', $data);
        $this->assertStringContainsString('Trace:', $data);
    }

    public function testFormatExceptionBody(): void
    {
        $renderer = new PlainTextRenderer();
        $exception = new TestException('test message', 456, new TestException());
        $data = $renderer->formatExceptionBody($exception);

        // Assert
        $this->assertStringContainsString('UserFrosting Application Error', $data);
        $this->assertStringContainsString('test message', $data);
        $this->assertStringContainsString('Previous Error:', $data);
        $this->assertStringContainsString('Trace:', $data);
    }

    public function testRender(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new PlainTextRenderer();
        $data = $renderer->render(
            request: $request,
            exception: new TestException(),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: false
        );

        // Assert
        $this->assertSame('Test exception', $data);
        $this->assertStringNotContainsString('UserFrosting Application Error', $data);
    }

    public function testRenderWithDisplayError(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new PlainTextRenderer();
        $data = $renderer->render(
            request: $request,
            exception: new TestException(),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: true
        );

        // Assert
        $this->assertStringContainsString('UserFrosting Application Error', $data);
    }
}
