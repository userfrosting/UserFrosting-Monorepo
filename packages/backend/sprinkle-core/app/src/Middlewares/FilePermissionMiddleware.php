<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Exceptions\BadConfigException;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Middleware used to check if the file permissions are correct.
 */
class FilePermissionMiddleware implements MiddlewareInterface
{
    /**
     * Inject dependencies.
     *
     * @param ResourceLocatorInterface $locator
     * @param Config                   $config
     */
    public function __construct(
        protected ResourceLocatorInterface $locator,
        protected Config $config,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        foreach ($this->config->get('writable') as $stream => $assertWriteable) {
            // Since config can't be removed, we skip if the value is null
            if ($assertWriteable === null) {
                continue;
            }

            // Translate stream to file path
            $file = $this->locator->findResource($stream);

            // Check if file exist and is writeable
            if ($file === null || $assertWriteable !== is_writable($file)) {
                // If file doesn't exist, we try to find the expected path
                $expectedPath = $this->locator->findResource($stream, false, true);

                throw new BadConfigException("Stream $stream doesn't exist and is not writeable. Make sure path `$expectedPath` exist and is writeable.");
            }
        }

        return $handler->handle($request);
    }
}
