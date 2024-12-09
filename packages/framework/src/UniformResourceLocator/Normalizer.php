<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\UniformResourceLocator;

use BadMethodCallException;

class Normalizer
{
    /**
     * Returns the canonicalize URI on success.
     * The resulting path will have no '/./' or '/../' components. Trailing delimiter `/` is kept.
     *
     * @param string $uri
     *
     * @throws BadMethodCallException On failure to process uri
     *
     * @return string Canonicalize URI as "scheme://path" or "path" if no scheme is present.
     */
    public static function normalize(string $uri): string
    {
        list($scheme, $path) = self::normalizeParts($uri);

        return ($scheme !== '') ? "{$scheme}://{$path}" : $path;
    }

    /**
     * Returns the canonicalize URI on success.
     * The resulting path will have no '/./' or '/../' components. Trailing delimiter `/` is kept.
     *
     * @param string $uri
     *
     * @throws BadMethodCallException On failure to process uri
     *
     * @return string[] As [scheme, path] array
     */
    public static function normalizeParts(string $uri): array
    {
        // Handle empty string
        if ($uri === '') {
            return ['', ''];
        }

        $separator = '/';

        // Parse $uri
        $uri = preg_replace('|\\\|u', $separator, $uri) ?? '';

        // Split `scheme://path` into each var
        $segments = explode('://', $uri, 2);
        $path = array_pop($segments);
        $scheme = array_pop($segments) ?? '';

        // Split each part of the path
        $parts = explode($separator, $path);

        // Parse each parts to handle relative portion of paths
        $list = [];
        foreach ($parts as $i => $part) {
            // If parts point to same directory, skip.
            // Also skip if part is empty, except for the first one.
            if (($part === '' && $i !== 0) || $part === '.') {
                continue;
            }

            // Handle when part point to parent dir.
            if ($part === '..') {
                // Remove parent from list
                $part = array_pop($list);

                // If removed part is null (out of score), part is empty, or
                // has ':' in it (out of scope, back to 'C://'), throw exception
                if ($part === null || $part === '' || strpos($part, ':') !== false) {
                    throw new BadMethodCallException('Invalid parameter $uri.');
                }

                continue;
            }

            // Add to list
            $list[] = $part;
        }

        // Get last part
        if (end($parts) === '') {
            $list[] = '';
        }

        $path = implode($separator, $list);

        return [$scheme, $path];
    }

    /**
     * Normalize a path:
     *  - Make sure all `\` (from a Windows path) are changed to `/`
     *  - Make sure a trailing slash is present
     *  - Doesn't change the beginning of the path (don't change absolute / relative path), but will change `C:\` to `C:/`.
     *
     * @param string $path
     *
     * @throws BadMethodCallException
     *
     * @return string Return false if path is invalid
     */
    public static function normalizePath(string $path): string
    {
        $path = self::normalize($path);

        // Before adding back `/`, make sure it's not empty again
        if ($path !== '') {
            $path = rtrim($path, '/') . '/';
        }

        return $path;
    }
}
