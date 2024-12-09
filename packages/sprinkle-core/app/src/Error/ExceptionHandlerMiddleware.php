<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpException;
use Throwable;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandler;
use UserFrosting\Sprinkle\Core\Error\Handler\ExceptionHandlerInterface;

/**
 * Default UserFrosting application error handler.
 *
 * It outputs the error message and diagnostic information in either JSON, XML, or HTML based on the Accept header.
 *
 * @see /Slim/Middlewares/ErrorMiddleware
 */
class ExceptionHandlerMiddleware implements MiddlewareInterface
{
    /**
     * @var string[] An array that maps Exception types to callbacks, for special processing of certain types of errors.
     */
    protected array $handlers = [];

    /**
     * @var string[]
     */
    protected array $subClassHandlers = [];

    /**
     * @var string
     */
    protected string $defaultErrorHandler = ExceptionHandler::class;

    /**
     * @param ContainerInterface $ci
     */
    public function __construct(
        protected ContainerInterface $ci
    ) {
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $e) {
            return $this->handleException($request, $e);
        }
    }

    /**
     * Invoke error handler.
     *
     * @param ServerRequestInterface $request   The most recent Request object
     * @param Throwable              $exception The caught Exception object
     *
     * @return ResponseInterface
     */
    public function handleException(ServerRequestInterface $request, Throwable $exception): ResponseInterface
    {
        if ($exception instanceof HttpException) {
            $request = $exception->getRequest();
        }

        $exceptionType = get_class($exception);
        $handler = $this->getErrorHandler($exceptionType);

        return $handler->handle($request, $exception);
    }

    /**
     * Get Exception Handler that handle what happens when an error
     * occurs when processing the current request.
     *
     * @param string $type Exception/Throwable name. ie: RuntimeException::class
     *
     * @return ExceptionHandlerInterface
     */
    public function getErrorHandler(string $type): ExceptionHandlerInterface
    {
        if (isset($this->handlers[$type])) {
            /** @var ExceptionHandlerInterface */
            return $this->ci->get($this->handlers[$type]);
        }

        if (isset($this->subClassHandlers[$type])) {
            /** @var ExceptionHandlerInterface */
            return $this->ci->get($this->subClassHandlers[$type]);
        }

        foreach ($this->subClassHandlers as $class => $handler) {
            if (is_subclass_of($type, $class)) {
                /** @var ExceptionHandlerInterface */
                return $this->ci->get($handler);
            }
        }

        return $this->getDefaultErrorHandler();
    }

    /**
     * Set the default Error Handler, when no specific handler is define for the
     * current exception.
     *
     * @param string $handler The fully qualified class name of the assigned handler.
     *
     * @return self
     */
    public function setDefaultErrorHandler(string $handler): self
    {
        if (!is_a($handler, ExceptionHandlerInterface::class, true)) {
            throw new InvalidArgumentException('Registered exception handler must implement ExceptionHandlerInterface');
        }

        $this->defaultErrorHandler = $handler;

        return $this;
    }

    /**
     * Get the default handler instance.
     *
     * @return ExceptionHandlerInterface
     */
    public function getDefaultErrorHandler(): ExceptionHandlerInterface
    {
        /** @var ExceptionHandlerInterface */
        return $this->ci->get($this->defaultErrorHandler);
    }

    /**
     * Register an exception handler for a specified exception class.
     *
     * The exception handler must implement \UserFrosting\Sprinkle\Core\Handler\ExceptionHandlerInterface.
     *
     * Pass true to $handleSubclasses to make the handler handle all subclasses of the type as well.
     *
     * @param string $type             The fully qualified class name of the exception to handle.
     * @param string $handler          The fully qualified class name of the assigned handler.
     * @param bool   $handleSubclasses
     *
     * @throws InvalidArgumentException If the registered handler fails to implement ExceptionHandlerInterface
     */
    public function registerHandler(string $type, string $handler, bool $handleSubclasses = false): self
    {
        if (!is_a($handler, ExceptionHandlerInterface::class, true)) {
            throw new InvalidArgumentException('Registered exception handler must implement ExceptionHandlerInterface');
        }

        if ($handleSubclasses) {
            $this->subClassHandlers[$type] = $handler;
        } else {
            $this->handlers[$type] = $handler;
        }

        return $this;
    }
}
