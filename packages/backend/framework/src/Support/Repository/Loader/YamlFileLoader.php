<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Repository\Loader;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use UserFrosting\Support\Exception\FileNotFoundException;
use UserFrosting\Support\Exception\JsonException;

/**
 * Load content from yaml/json files.
 */
class YamlFileLoader extends FileRepositoryLoader
{
    /**
     * {@inheritdoc}
     */
    protected function parseFile(string $path): array
    {
        $doc = $this->fileGetContents($path);
        if ($doc === false) {
            throw new FileNotFoundException("The file '$path' could not be read.");
        }

        try {
            $result = Yaml::parse($doc);
        } catch (ParseException $e) {
            // Fallback to try and parse as JSON, if it fails to be parsed as YAML
            $result = json_decode($doc, true);
            if ($result === null) {
                throw new JsonException("The file '$path' does not contain a valid YAML or JSON document.  JSON error: " . json_last_error());
            }
        }

        // In case `Yaml::parse` returns empty data/file
        if (is_null($result)) {
            return [];
        }

        return $result;
    }

    /**
     * Reads entire path into a string.
     *
     * @param string $path
     *
     * @return string|false
     */
    protected function fileGetContents(string $path): string|false
    {
        return file_get_contents($path);
    }
}
