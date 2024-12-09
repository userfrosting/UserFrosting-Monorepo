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

use Illuminate\Cache\ArrayStore as IlluminateArrayStore;
use Illuminate\Contracts\Cache\Store;

/**
 * Setup a cache instance using the `array` driver.
 * This driver is a dummy one that doesn't save anything, and should primally
 * be used for testing or disabling cache.
 */
class ArrayStore extends AbstractStore
{
    /**
     * Create the Illuminate ArrayStore.
     */
    public function getStore(): Store
    {
        return new IlluminateArrayStore();
    }
}
