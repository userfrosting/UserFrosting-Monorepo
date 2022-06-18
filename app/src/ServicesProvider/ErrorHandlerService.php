<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\ServicesProvider;

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Admin\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupNotFoundException;
use UserFrosting\Sprinkle\Admin\Exceptions\PermissionNotFoundException;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleNotFoundException;
use UserFrosting\Sprinkle\Core\Error\ExceptionHandlerMiddleware;
use UserFrosting\Sprinkle\Core\Error\Handler\UserFacingExceptionHandler;

class ErrorHandlerService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            /**
             * Register custom Handler.
             */
            // TODO : Add custom handler which each one can extend, so only one is registered here.
            ExceptionHandlerMiddleware::class => \DI\decorate(function (ExceptionHandlerMiddleware $middleware) {
                $middleware->registerHandler(GroupNotFoundException::class, UserFacingExceptionHandler::class);
                $middleware->registerHandler(RoleNotFoundException::class, UserFacingExceptionHandler::class);
                $middleware->registerHandler(PermissionNotFoundException::class, UserFacingExceptionHandler::class);
                $middleware->registerHandler(AccountNotFoundException::class, UserFacingExceptionHandler::class);

                return $middleware;
            }),
        ];
    }
}
