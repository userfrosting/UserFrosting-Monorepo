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
interface ResourceStreamInterface
{
    /**
     * @return string
     */
    public function getScheme(): string;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return bool
     */
    public function isShared(): bool;

    /**
     * Is the stream read only.
     *
     * @return bool
     */
    public function isReadonly(): bool;
}
