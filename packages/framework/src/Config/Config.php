<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Config;

use UserFrosting\Support\Repository\Repository;

/**
 * Config Repository. Adds type specific getters.
 */
class Config extends Repository
{
    /**
     * Get the specified configuration value as bool.
     * Returns null if the key is not found, unless a default is provided, in
     * which case the return value is type safe (can't be null).
     *
     * @param string    $key
     * @param bool|null $default
     *
     * @return ($default is null ? bool|null : bool)
     */
    public function getBool(string $key, ?bool $default = null): ?bool
    {
        $value = $this->get($key, $default) ?? $default;

        if (!is_bool($value) && !is_null($value)) {
            throw new TypeException("Config key '$key' doesn't return bool.");
        }

        return $value;
    }

    /**
     * Get the specified configuration value as bool.
     * Returns null if the key is not found, unless a default is provided, in
     * which case the return value is type safe (can't be null).
     *
     * @param string      $key
     * @param string|null $default
     *
     * @return ($default is null ? string|null : string)
     */
    public function getString(string $key, ?string $default = null): ?string
    {
        $value = $this->get($key, $default) ?? $default;

        if (!is_string($value) && !is_null($value)) {
            throw new TypeException("Config key '$key' doesn't return string.");
        }

        return $value;
    }

    /**
     * Get the specified configuration value as bool.
     * Returns null if the key is not found, unless a default is provided, in
     * which case the return value is type safe (can't be null).
     *
     * @param string   $key
     * @param int|null $default
     *
     * @return ($default is null ? int|null : int)
     */
    public function getInt(string $key, ?int $default = null): ?int
    {
        $value = $this->get($key, $default) ?? $default;

        if (!is_int($value) && !is_null($value)) {
            throw new TypeException("Config key '$key' doesn't return int.");
        }

        return $value;
    }

    /**
     * Get the specified configuration value as bool.
     * Returns null if the key is not found, unless a default is provided, in
     * which case the return value is type safe (can't be null).
     *
     * @param string       $key
     * @param mixed[]|null $default
     *
     * @return ($default is null ? mixed[]|null : mixed[])
     */
    public function getArray(string $key, ?array $default = null): ?array
    {
        $value = $this->get($key, $default) ?? $default;

        if (!is_array($value) && !is_null($value)) {
            throw new TypeException("Config key '$key' doesn't return array.");
        }

        return $value;
    }
}
