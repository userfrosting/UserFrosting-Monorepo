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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * All exception handlers must implement this interface.
 */
interface ExceptionHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, Throwable $exception): ResponseInterface;
}
