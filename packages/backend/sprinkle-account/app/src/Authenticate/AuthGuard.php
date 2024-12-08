<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Authenticate;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use UserFrosting\Sprinkle\Account\Exceptions\AuthGuardException;

/**
 * Middleware to catch requests that fail because they require user authentication.
 */
class AuthGuard
{
    /**
     * @param Authenticator $authenticator The current authentication object.
     */
    public function __construct(
        protected Authenticator $authenticator
    ) {
    }

    /**
     * Invoke the AuthGuard middleware, throwing an exception if there is no
     * authenticated user in the session. Sprinkle can handle this exception
     * to handle the way they want.
     *
     * @param Request        $request
     * @param RequestHandler $handler
     *
     * @return ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (!$this->authenticator->check()) {
            throw new AuthGuardException();
        }

        return $handler->handle($request);
    }
}
