<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support\Repository;

use Illuminate\Config\Repository as IlluminateRepository;
use Illuminate\Support\Arr;
use UserFrosting\Support\Util\Util;

/**
 * Repository Class.
 *
 * Represents an extendable repository of key->value mappings.
 */
class Repository extends IlluminateRepository
{
    /**
     * Recursively merge values (scalar or array) into this repository.
     *
     * If no key is specified, the items will be merged in starting from the top level of the array.
     * If a key IS specified, items will be merged into that key.
     * Nested keys may be specified using dot syntax.
     *
     * @param string|null $key
     * @param mixed       $items
     *
     * @return static
     */
    public function mergeItems(?string $key, mixed $items): static
    {
        $targetValues = Arr::get($this->items, $key);

        if (is_array($targetValues) && is_array($items)) {
            $modifiedValues = array_replace_recursive($targetValues, $items);
        } else {
            $modifiedValues = $items;
        }

        Arr::set($this->items, $key, $modifiedValues);

        return $this;
    }

    /**
     * Get the specified configuration value, recursively removing all null values.
     *
     * @param string|mixed[]|null $key
     *
     * @return mixed
     */
    public function getDefined(string|array|null $key = null): mixed
    {
        $result = $this->get($key); // @phpstan-ignore-line Laravel param is wrong
        if (!is_array($result)) {
            return $result;
        }

        return Util::arrayFilterRecursive($result, function ($value) {
            return !is_null($value);
        });
    }
}
