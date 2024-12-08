<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Cache\Driver;

use Illuminate\Cache\TaggedCache;

/**
 * Custom file based cache driver with supports for Tags
 * Inspired by unikent/taggedFileCache.
 */
class TaggedFileCache extends TaggedCache
{
    /**
     * {@inheritdoc}
     */
    public function taggedItemKey($key)
    {
        // @phpstan-ignore-next-line - TaggableFileStore will be used
        return $this->tags->getNamespace() . $this->store->separator . $key;
    }
}
