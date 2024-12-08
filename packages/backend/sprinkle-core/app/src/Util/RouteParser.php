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

use Psr\Http\Message\UriInterface;
use RuntimeException;
use Slim\Interfaces\RouteCollectorInterface;

/**
 * Wrapper around Slim's RouteParser. Allows to add 'fallback' routes when names
 * routes are not found.
 *
 * @see https://github.com/userfrosting/UserFrosting/issues/1244
 */
class RouteParser implements RouteParserInterface
{
    public function __construct(
        protected RouteCollectorInterface $routeCollector,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function relativeUrlFor(
        string $routeName,
        array $data = [],
        array $queryParams = [],
        ?string $fallbackRoute = null,
    ): string {
        try {
            $result = $this->routeCollector->getRouteParser()->relativeUrlFor($routeName, $data, $queryParams);
        } catch (RuntimeException $e) {
            if ($fallbackRoute !== null) {
                $result = $fallbackRoute;
            } else {
                throw $e;
            }
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function urlFor(
        string $routeName,
        array $data = [],
        array $queryParams = [],
        ?string $fallbackRoute = null,
    ): string {
        try {
            $result = $this->routeCollector->getRouteParser()->urlFor($routeName, $data, $queryParams);
        } catch (RuntimeException $e) {
            if ($fallbackRoute !== null) {
                $basePath = $this->routeCollector->getBasePath();
                $result = $basePath . $fallbackRoute;
            } else {
                throw $e;
            }
        }

        return $result;
    }

    /**
     * {@inheritDoc}
     */
    public function fullUrlFor(
        UriInterface $uri,
        string $routeName,
        array $data = [],
        array $queryParams = [],
        ?string $fallbackRoute = null,
    ): string {
        try {
            $result = $this->routeCollector->getRouteParser()->fullUrlFor($uri, $routeName, $data, $queryParams);
        } catch (RuntimeException $e) {
            if ($fallbackRoute !== null) {
                $path = $this->urlFor($routeName, $data, $queryParams, $fallbackRoute);
                $scheme = $uri->getScheme();
                $authority = $uri->getAuthority();
                $protocol = ($scheme !== '' ? $scheme . ':' : '') . ($authority !== '' ? '//' . $authority : '');
                $result = $protocol . $path;
            } else {
                throw $e;
            }
        }

        return $result;
    }
}
