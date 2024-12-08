<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error\Handler;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Psr7\Factory\ResponseFactory;
use Throwable;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Error\Renderer\ErrorRendererInterface;
use UserFrosting\Sprinkle\Core\Error\Renderer\JsonRenderer;
use UserFrosting\Sprinkle\Core\Error\Renderer\PlainTextRenderer;
use UserFrosting\Sprinkle\Core\Error\Renderer\PrettyPageRenderer;
use UserFrosting\Sprinkle\Core\Error\Renderer\XmlRenderer;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Sprinkle\Core\Log\ErrorLoggerInterface;
use UserFrosting\Sprinkle\Core\Util\DeterminesContentTypeTrait;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use UserFrosting\Support\Exception\BadInstanceOfException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Generic handler for exceptions.
 */
class ExceptionHandler implements ExceptionHandlerInterface
{
    use DeterminesContentTypeTrait;

    /**
     * @var string[] Renderers for specific content types.
     */
    protected array $errorRenderers = [
        'application/json' => JsonRenderer::class,
        'application/xml'  => XmlRenderer::class,
        'text/xml'         => XmlRenderer::class,
        'text/html'        => PrettyPageRenderer::class,
        'text/plain'       => PlainTextRenderer::class,
    ];

    /**
     * @var string Renderer for log messages
     */
    protected string $logFormatter = PlainTextRenderer::class;

    /**
     * @param ContainerInterface $ci
     * @param ResponseFactory    $responseFactory
     * @param Config             $config
     * @param Translator         $translator
     */
    public function __construct(
        protected ContainerInterface $ci,
        protected ResponseFactory $responseFactory,
        protected Config $config,
        protected Translator $translator,
        protected ErrorLoggerInterface $logger,
    ) {
    }

    /**
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        // Log error if required
        if ($this->shouldLogExceptions()) {
            $this->writeToErrorLog($request, $exception);
        }

        // Render Response
        $response = $this->renderResponse($request, $exception);

        return $response;
    }

    /**
     * Render a detailed response with debugging information.
     *
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     *
     * @return ResponseInterface
     */
    public function renderResponse(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        $statusCode = $this->determineStatusCode($request, $exception);
        $contentType = $this->determineContentType($request, array_keys($this->errorRenderers));

        // Determine which renderer to use based on the content type and required details
        $renderer = $this->determineRenderer($contentType);

        // Get response
        $response = $this->responseFactory->createResponse($statusCode);

        // Determine user facing message
        $userMessage = $this->determineUserMessage($exception, $statusCode);

        // Write to the response body
        $body = $renderer->render($request, $exception, $userMessage, $statusCode, $this->displayErrorDetails());
        $response->getBody()->write($body);

        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-type', $contentType);
    }

    /**
     * Write to the error log.
     *
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     */
    public function writeToErrorLog(ServerRequestInterface $request, Throwable $exception): void
    {
        $renderer = $this->ci->get($this->logFormatter);
        if (!$renderer instanceof ErrorRendererInterface) {
            throw new BadInstanceOfException("{$this->logFormatter} is not an instance of ErrorRendererInterface");
        }

        $statusCode = $this->determineStatusCode($request, $exception);
        $userMessage = $this->determineUserMessage($exception, $statusCode); // Don't need this here?

        $error = $renderer->render($request, $exception, $userMessage, $statusCode, true);

        $this->logger->error($error);
    }

    /**
     * @return bool
     */
    protected function shouldLogExceptions(): bool
    {
        return boolval($this->config->get('logs.exception'));
    }

    /**
     * @return bool
     */
    protected function displayErrorDetails(): bool
    {
        return boolval($this->config->get('debug.exception'));
    }

    /**
     * Determine which renderer to use based on content type
     * Overloaded $renderer from calling class takes precedence over all.
     *
     * @param string $contentType
     *
     * @throws \RuntimeException
     *
     * @return ErrorRendererInterface
     */
    protected function determineRenderer(string $contentType): ErrorRendererInterface
    {
        // determineContentType already make sure we have a valid content type.
        $renderer = $this->errorRenderers[$contentType];

        // Make sure it's a valid interface before returning
        $rendererInstance = $this->ci->get($renderer);
        if (!$rendererInstance instanceof ErrorRendererInterface) {
            throw new BadInstanceOfException("$renderer is not an instance of ErrorRendererInterface");
        }

        return $rendererInstance;
    }

    /**
     * Resolve the status code to return in the response from this handler.
     *
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     *
     * @return int
     */
    protected function determineStatusCode(ServerRequestInterface $request, Throwable $exception): int
    {
        if ($request->getMethod() === 'OPTIONS') {
            return 200;
        }

        return 500;
    }

    /**
     * Return the end user message.
     *
     * @param Throwable $exception
     * @param int       $statusCode
     *
     * @return Message
     */
    protected function determineUserMessage(Throwable $exception, int $statusCode): Message
    {
        if ($exception instanceof UserMessageException) {
            return new Message(
                $this->translateUserMessage($exception->getTitle()),
                $this->translateUserMessage($exception->getDescription())
            );
        }

        return new Message(
            $this->translateStatusMessage($statusCode, 'ERROR.%d.TITLE', 'ERROR.TITLE'),
            $this->translateStatusMessage($statusCode, 'ERROR.%d.DESCRIPTION', 'ERROR.DESCRIPTION')
        );
    }

    /**
     * Return the translated version of a UserMessage|string.
     *
     * @param string|UserMessage $userMessage
     *
     * @return string
     */
    protected function translateUserMessage(string|UserMessage $userMessage): string
    {
        if (is_string($userMessage)) {
            return $this->translator->translate($userMessage);
        }

        return $this->translator->translate($userMessage->message, $userMessage->parameters);
    }

    /**
     * Get the right message based on status code, and returned the translated version.
     *
     * @param int    $statusCode
     * @param string $format
     * @param string $fallback
     *
     * @return string
     */
    protected function translateStatusMessage(int $statusCode, string $format, string $fallback): string
    {
        // Get locale dictionary from translator
        $dictionary = $this->translator->getDictionary();

        // If dictionary has string, returns it, otherwise, use fallback
        if ($dictionary->has(sprintf($format, $statusCode))) {
            return $this->translator->translate(sprintf($format, $statusCode));
        }

        return $this->translator->translate(sprintf($fallback, $statusCode));
    }

    /**
     * Register new content renderer.
     *
     * @param string $contentType
     * @param string $errorRenderer
     */
    public function registerErrorRenderer(string $contentType, string $errorRenderer): void
    {
        if (!is_a($errorRenderer, ErrorRendererInterface::class, true)) {
            throw new InvalidArgumentException('Registered error renderer must implement ErrorRendererInterface');
        }

        $this->errorRenderers[$contentType] = $errorRenderer;
    }
}
