<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Authenticate;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use UserFrosting\Sprinkle\Account\Exceptions\LoggedInException;

/**
 * Middleware to catch requests that fail because they require user NOT to be authenticated.
 */
class GuestGuard
{
    /**
     * @param Authenticator $authenticator The current authentication object.
     */
    public function __construct(
        protected Authenticator $authenticator
    ) {
    }

    /**
     * Invoke the GuestGuard middleware, throwing an exception if there IS a
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
        if ($this->authenticator->check()) {
            throw new LoggedInException();
        }

        return $handler->handle($request);
    }
}
