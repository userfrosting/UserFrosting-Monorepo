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

use Illuminate\Cache\Repository as Cache;
use Illuminate\Contracts\Cache\Store;

abstract class AbstractStore
{
    /**
     * Create the appropriate Illuminate Store.
     */
    abstract public function getStore(): Store;

    /**
     * Return the Cache instance.
     *
     * @return Cache
     */
    public function instance(): Cache
    {
        $store = $this->getStore();

        return new Cache($store);
    }
}
