<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\Error\Handler;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Slim\Psr7\Factory\ResponseFactory;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Error\Handler\PhpMailerExceptionHandler;
use UserFrosting\Sprinkle\Core\Error\Renderer\ErrorRendererInterface;
use UserFrosting\Sprinkle\Core\Error\Renderer\PlainTextRenderer;
use UserFrosting\Sprinkle\Core\Error\Renderer\PrettyPageRenderer;
use UserFrosting\Sprinkle\Core\Log\ErrorLogger;

/**
 * PhpMailerExceptionHandler Test
 */
class PhpMailerExceptionHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandle(): void
    {
        // Mock Config to control the settings
        /** @var Config $config */
        $config = Mockery::mock(Config::class)
            ->shouldReceive('get')->with('debug.exception')->once()->andReturn(true)
            ->shouldReceive('get')->with('logs.exception')->once()->andReturn(true)
            ->getMock();

        /** @var ErrorRendererInterface $renderer */
        $renderer = Mockery::mock(ErrorRendererInterface::class)
            ->shouldReceive('render')->once()->andReturn('Some body')
            ->getMock();

        /** @var ErrorRendererInterface $renderer */
        $textRenderer = Mockery::mock(ErrorRendererInterface::class)
            ->shouldReceive('render')->once()->andReturn('Some text body')
            ->getMock();

        // Mock CI and decide witch renderer is passed
        /** @var ContainerInterface $ci */
        $ci = Mockery::mock(ContainerInterface::class)
            ->shouldReceive('get')->with(PrettyPageRenderer::class)->once()->andReturn($renderer) // Display
            ->shouldReceive('get')->with(PlainTextRenderer::class)->once()->andReturn($textRenderer) // Logger
            ->getMock();

        // Return from getBody of response
        /** @var StreamInterface $streamInterface */
        $streamInterface = Mockery::mock(StreamInterface::class)
            ->shouldReceive('write')->once()
            ->getMock();

        // Mocked response
        /** @var ResponseInterface $response */
        $response = Mockery::mock(ResponseInterface::class)
            ->shouldReceive('getBody')->once()->andReturn($streamInterface)
            ->shouldReceive('withStatus')->with(500)->once()->andReturnSelf()
            ->shouldReceive('withHeader')->with('Content-type', 'text/html')->once()->andReturnSelf()
            ->getMock();

        // Mock for ResponseFactory
        /** @var ResponseFactory $responseFactory */
        $responseFactory = Mockery::mock(ResponseFactory::class)
            ->shouldReceive('createResponse')->with(500)->once()->andReturn($response)
            ->getMock();

        /** @var Translator $translator */
        $translator = Mockery::mock(Translator::class)
            ->shouldReceive('translate')->with('ERROR.MAIL')->times(2)->andReturn('Error mail') // <-- Here important part
            ->getMock();

        /** @var ErrorLogger $logger */
        $logger = Mockery::mock(ErrorLogger::class)
            ->shouldReceive('error')->with('Some text body')->once()
            ->getMock();

        /** @var ServerRequestInterface $request */
        $request = Mockery::mock(ServerRequestInterface::class)
            ->shouldReceive('getMethod')->times(2)->andReturn('GET')
            ->shouldReceive('getHeaderLine')->with('Accept')->once()->andReturn('text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8')
            ->getMock();

        // Get handler
        $handler = new PhpMailerExceptionHandler($ci, $responseFactory, $config, $translator, $logger);

        // Do stuff
        $result = $handler->handle($request, new PHPMailerException('Mail error message'));

        // Assert
        $this->assertSame($response, $result);
    }
}
