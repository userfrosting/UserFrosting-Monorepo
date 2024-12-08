<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Csrf;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UserFrosting\Config\Config;

/**
 * Wrapper for Slim-Csrf Guard.
 *
 * While the Guard class implements MiddlewareInterface, it's constructor
 * requires session to be active. Since dependency injection call the
 * constructor every time, we wrap it in this middleware so the constructor
 * (and thus session) is only called when the middleware is used, not when it's
 * added to the app. Otherwise, session is called even if CSRF is disabled /
 * middleware not called.
 */
class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected ContainerInterface $ci,
        protected Config $config,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Global on/off switch. Skip if csrf is globally disabled.
        if ($this->config->getBool('csrf.enabled') === false) {
            return $handler->handle($request);
        }

        /** @var CsrfGuard */
        $guard = $this->ci->get(CsrfGuard::class);

        return $guard->process($request, $handler);
    }
}
