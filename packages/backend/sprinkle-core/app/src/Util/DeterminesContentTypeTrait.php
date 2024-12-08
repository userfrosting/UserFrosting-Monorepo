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
 * Trait for classes that need to determine a request's accepted content type(s).
 */
trait DeterminesContentTypeTrait
{
    /**
     * Determine which content type we know about is wanted using Accept header.
     *
     * Note: This method is a bare-bones implementation designed specifically for
     * Slim's error handling requirements. Consider a fully-feature solution such
     * as willdurand/negotiation for any other situation.
     *
     * @param ServerRequestInterface $request
     * @param string[]               $knownContentTypes
     * @param string                 $defaultType
     *
     * @return string
     */
    protected function determineContentType(
        ServerRequestInterface $request,
        array $knownContentTypes = [],
        string $defaultType = 'text/html',
    ): string {
        $acceptHeader = $request->getHeaderLine('Accept');
        $selectedContentTypes = array_intersect(explode(',', $acceptHeader), $knownContentTypes);
        $count = count($selectedContentTypes);

        if ($count !== 0) {
            $current = current($selectedContentTypes);

            /*
             * Ensure other supported content types take precedence over text/plain
             * when multiple content types are provided via Accept header.
             */
            if ($current === 'text/plain' && $count > 1) {
                /** @var string */
                return next($selectedContentTypes);
            }

            return $current;
        }

        if (preg_match('/\+(json|xml)/', $acceptHeader, $matches) === 1) {
            $mediaType = 'application/' . $matches[1];
            if (in_array($mediaType, $knownContentTypes, true)) {
                return $mediaType;
            }
        }

        return $defaultType;
    }
}
