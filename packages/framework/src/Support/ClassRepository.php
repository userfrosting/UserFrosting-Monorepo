<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Support;

use ArrayIterator;
use Countable;
use Iterator;
use IteratorAggregate;
use UserFrosting\Support\Exception\ClassNotFoundException;

/**
 * Handle a PHP class repository.
 *
 * @template T of object
 *
 * @implements ClassRepositoryInterface<T>
 */
abstract class ClassRepository implements ClassRepositoryInterface
{
    /**
     * Return all classes.
     *
     * @return T[] A list of classes instances.
     */
    abstract public function all(): array;

    /**
     * Returns the same list as all, but as a list of class names.
     *
     * @return class-string[] A list class FQN.
     */
    public function list(): array
    {
        return array_map(function ($m) {
            return get_class($m);
        }, $this->all());
    }

    /**
     * Return the requested class instance from the repository.
     *
     * @param class-string $class Class FQN.
     *
     * @return T
     */
    public function get(string $class): object
    {
        if (!$this->has($class)) {
            throw new ClassNotFoundException("Class `$class` not found.");
        }

        $results = array_filter($this->all(), function ($m) use ($class) {
            return get_class($m) === $class;
        });

        return array_values($results)[0]; // TODO : Test array_values with filter not being on key 0
    }

    /**
     * Validate if a specific class exist.
     *
     * @param class-string $class Class FQN.
     *
     * @return bool
     */
    public function has(string $class): bool
    {
        return in_array($class, $this->list(), true);
    }

    /**
     * Countable implementation.
     */
    public function count(): int
    {
        return count($this->all());
    }

    /**
     * IteratorAggregate implementation.
     *
     * @return Iterator<int, T>
     */
    public function getIterator(): Iterator
    {
        return new ArrayIterator($this->all());
    }
}
