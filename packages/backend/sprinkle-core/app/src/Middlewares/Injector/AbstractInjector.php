<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Middlewares\Injector;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

/**
 * Route middleware to inject a model instance when it's id/slug is passed via
 * placeholder in the URL or request query.
 *
 * For example, if the route is `/users/{slug}`, an Injector will replace the
 * `{slug}` placeholder string with the associated model instance in the
 * controller dependency injection, or throw not found error.
 */
abstract class AbstractInjector implements MiddlewareInterface
{
    // Route placeholder variable name. Ie 'slug' in `/users/{slug}`
    protected string $placeholder = 'slug';

    // Middleware attribute name. Name of the variable that will be injected in
    // the controller. Ie 'user' = `__construct($user)`
    protected string $attribute = 'model';

    /**
     * {@inheritdoc}
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $placeholder = $this->getIdFromRoute($request) ?? $this->getIdFromQuery($request);
        $instance = $this->getInstance($placeholder);
        $request = $request->withAttribute($this->attribute, $instance);

        return $handler->handle($request);
    }

    /**
     * Get the model's id from the request placeholder.
     *
     * @param ServerRequestInterface $request
     *
     * @return string|null
     */
    protected function getIdFromRoute(ServerRequestInterface $request): ?string
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        return $route?->getArgument($this->placeholder);
    }

    /**
     * Get the model's id from the request query (GET) variables.
     *
     * @param ServerRequestInterface $request
     *
     * @return string|null
     */
    protected function getIdFromQuery(ServerRequestInterface $request): ?string
    {
        $queryParams = $request->getQueryParams();

        return $queryParams[$this->placeholder] ?? null;
    }

    /**
     * Returns the model's instance. This method must be implemented by the
     * concrete class. It should return the model instance from the database,
     * using the id passed as argument.
     *
     * @param string|null $id
     *
     * @return object
     */
    abstract protected function getInstance(?string $id): object;
}
