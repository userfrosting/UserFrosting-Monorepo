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
use UserFrosting\Sprinkle\Core\Error\Renderer\XmlRenderer;
use UserFrosting\Sprinkle\Core\Tests\Unit\Error\TestException;
use UserFrosting\Sprinkle\Core\Util\Message\Message;

/**
 * XmlRenderer Test
 *
 * WARNING : This test validates the appropriates dependencies are called the
 * code doesn't throws any errors. The actual output is not fully tested.
 */
class XmlRendererTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testRender(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');

        // Create renderer and render exception
        $renderer = new XmlRenderer();
        $data = $renderer->render(
            request: $request,
            exception: new TestException(),
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: false
        );

        // Assert
        $xml = simplexml_load_string($data);
        $this->assertNotFalse($xml);
        $this->assertTrue(property_exists($xml, 'message'));
        $this->assertFalse(property_exists($xml, 'exception'));
    }

    public function testRenderWithDisplayError(): void
    {
        // Mocks
        $request = Mockery::mock(Request::class);
        $userMessage = new Message('title', 'description');
        $exception = new TestException();

        // Create renderer and render exception
        $renderer = new XmlRenderer();

        $data = $renderer->render(
            request: $request,
            exception: $exception,
            userMessage: $userMessage,
            statusCode: 234,
            displayErrorDetails: true
        );

        // Assert
        $xml = simplexml_load_string($data);
        $this->assertNotFalse($xml);
        $this->assertTrue(property_exists($xml, 'message'));
        $this->assertTrue(property_exists($xml, 'exception'));
    }
}
