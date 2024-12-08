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

/**
 * The representation of a stream.
 */
class ResourceStream implements ResourceStreamInterface
{
    /**
     * @param string $scheme
     * @param string $path
     * @param bool   $shared
     * @param bool   $readonly
     */
    public function __construct(
        protected string $scheme,
        protected ?string $path = null,
        protected bool $shared = false,
        protected bool $readonly = false,
    ) {
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * Path default to scheme when null.
     *
     * @return string
     */
    public function getPath(): string
    {
        if ($this->path === null) {
            return Normalizer::normalizePath($this->getScheme());
        }

        return Normalizer::normalizePath($this->path);
    }

    /**
     * @return bool
     */
    public function isShared(): bool
    {
        return $this->shared;
    }

    /**
     * {@inheritDoc}
     */
    public function isReadonly(): bool
    {
        return $this->readonly;
    }
}
