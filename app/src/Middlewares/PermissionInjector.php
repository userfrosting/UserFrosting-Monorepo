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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Exceptions\PermissionNotFoundException;

/**
 * Helper class when a permission is defined by id in the URL.
 */
class PermissionInjector implements MiddlewareInterface
{
    // Route placeholder
    protected string $placeholder = 'id';

    // Middleware attribute name.
    protected string $attribute = 'permission';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected PermissionInterface $model,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $placeholder = $this->getPlaceholderFromRequest($request);
        $instance = $this->getInstance($placeholder);
        $request = $request->withAttribute($this->attribute, $instance);

        return $handler->handle($request);
    }

    /**
     * Get the permission's id from the request.
     *
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    protected function getPlaceholderFromRequest(ServerRequestInterface $request): string
    {
        $routeContext = RouteContext::fromRequest($request);
        $route = $routeContext->getRoute();

        return $route?->getArgument($this->placeholder) ?? '';
    }

    /**
     * Returns the permission's instance.
     *
     * @param string $id
     *
     * @return PermissionInterface
     */
    protected function getInstance(string $id): PermissionInterface
    {
        /** @var null|PermissionInterface */
        $instance = $this->model->find($id);

        // If the user doesn't exist, return 404
        if ($instance === null) {
            throw new PermissionNotFoundException();
        }

        return $instance;
    }
}
