<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error\Renderer;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use UserFrosting\Sprinkle\Core\Util\Message\Message;

/**
 * ErrorRendererInterface.
 */
interface ErrorRendererInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param Throwable              $exception
     * @param Message                $userMessage         User facing message
     * @param int                    $statusCode
     * @param bool                   $displayErrorDetails
     *
     * @return string
     */
    public function render(
        ServerRequestInterface $request,
        Throwable $exception,
        Message $userMessage,
        int $statusCode,
        bool $displayErrorDetails = false
    ): string;
}
