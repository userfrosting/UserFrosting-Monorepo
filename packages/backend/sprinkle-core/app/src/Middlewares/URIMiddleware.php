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
use Psr\Http\Message\UriInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UserFrosting\Config\Config;

class URIMiddleware implements MiddlewareInterface
{
    /**
     * @param Config $config
     */
    public function __construct(
        protected Config $config,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Construct base url from request, if not explicitly specified
        if (!is_string($this->config->get('site.uri.public')) || $this->config->get('site.uri.public') === '') {
            $uri = $request->getUri();
            $baseUrl = $this->getBaseUrl($uri);
            $this->config->set('site.uri.public', $baseUrl);
        }

        return $handler->handle($request);
    }

    /**
     * Return the fully qualified base URL.
     *
     * Note that this method never includes a trailing /
     *
     * @see https://github.com/slimphp/Slim-Psr7/blob/44779a0189349e97accb1a8d0c2c32ada8c9fb5a/src/Uri.php#L458-L486
     *
     * @return string
     */
    public function getBaseUrl(UriInterface $uri): string
    {
        $scheme = $uri->getScheme();
        $authority = $uri->getAuthority();

        return ($scheme !== '' ? $scheme . ':' : '')
            . ($authority !== '' ? '//' . $authority : '');
    }
}
