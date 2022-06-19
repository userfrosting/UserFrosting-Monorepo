<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteContext;

/**
 * Route middleware to inject a model when it's id is passed via placeholder in the URL or request query.
 */
abstract class AbstractInjector implements MiddlewareInterface
{
    // Route placeholder
    protected string $placeholder = 'slug';

    // Middleware attribute name.
    protected string $attribute = 'model';

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
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
     * Returns the model's instance.
     *
     * @param string|null $id
     *
     * @return object
     */
    abstract protected function getInstance(?string $id): object;
}
