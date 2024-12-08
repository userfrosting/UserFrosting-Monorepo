<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Util;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Helper methods to store and retrieve the server request.
 * The request can be null if it's not set yet (eg. before the request is saved
 * by the middleware) or if there's no server request (eg. in a CLI command).
 */
class RequestContainer
{
    /**
     * @var ServerRequestInterface|null
     */
    protected ?ServerRequestInterface $request = null;

    /**
     * Return the server request.
     *
     * @return ServerRequestInterface|null
     */
    public function getRequest(): ?ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * Store the server request.
     *
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request): void
    {
        $this->request = $request;
    }
}
