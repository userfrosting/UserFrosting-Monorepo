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

use Stringable;

/**
 * The representation of a resource.
 */
interface ResourceInterface extends Stringable
{
    /**
     * Get Resource URI.
     *
     * @return string
     */
    public function getUri(): string;

    /**
     * Get the resource base path, aka the path that comes after the `://`.
     *
     * @return string
     */
    public function getBasePath(): string;

    /**
     * Extract the resource filename (test.txt -> test).
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Extract the trailing name component (test.txt -> test.txt).
     *
     * @return string
     */
    public function getBasename(): string;

    /**
     * Extract the resource extension (test.txt -> txt).
     *
     * @return string
     */
    public function getExtension(): string;

    /**
     * @return ResourceLocationInterface|null
     */
    public function getLocation(): ?ResourceLocationInterface;

    /**
     * @return string
     */
    public function getAbsolutePath(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return string
     */
    public function getLocatorBasePath(): string;

    /**
     * @return ResourceStreamInterface
     */
    public function getStream(): ResourceStreamInterface;
}
