<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Cache;

use Illuminate\Cache\FileStore as IlluminateFileStore;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Filesystem\Filesystem;

/**
 * Setup a cache instance using the `file` driver.
 */
class FileStore extends AbstractStore
{
    /**
     * Accept the file driver $path.
     *
     * @param string $path (default: "./")
     */
    public function __construct(protected $path = './')
    {
    }

    /**
     * Create the Illuminate FileStore.
     */
    public function getStore(): Store
    {
        return new IlluminateFileStore(new Filesystem(), $this->path);
    }
}
