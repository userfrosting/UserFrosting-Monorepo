<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Repository\PathBuilder;

/**
 * An example builder class that simply globs together all PHP files in each search path.
 */
class SimpleGlobBuilder extends PathBuilder
{
    /**
     * Glob together all file paths in each search path from the locator.
     *
     * @param string $extension (default 'php')
     *
     * @return string[]
     */
    public function buildPaths(string $extension = 'php'): array
    {
        // Get all paths from the locator that match the uri.
        // Put them in reverse order to allow later files to override earlier files.
        $searchPaths = array_reverse($this->locator->getResources($this->uri, true));

        $filePaths = [];
        foreach ($searchPaths as $path) {
            $globs = glob(rtrim((string) $path, '/\\') . '/*.' . $extension);
            $globs = ($globs === false) ? [] : $globs;
            $filePaths = array_merge($filePaths, $globs);
        }

        return $filePaths;
    }
}
