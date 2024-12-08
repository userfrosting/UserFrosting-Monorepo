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

use Countable;
use IteratorAggregate;

/**
 * Implements a PHP class repository.
 *
 * @template T of object
 *
 * @extends IteratorAggregate<int, T>
 */
interface ClassRepositoryInterface extends Countable, IteratorAggregate
{
    /**
     * Return all classes.
     *
     * @return T[] A list of classes instances.
     */
    public function all(): array;

    /**
     * Returns the same list as all, but as a list of class names.
     *
     * @return class-string[] A list class FQN.
     */
    public function list(): array;

    /**
     * Return the requested class instance from the repository.
     *
     * @param class-string $class Class FQN.
     *
     * @return T
     */
    public function get(string $class): object;

    /**
     * Validate if a specific class exist.
     *
     * @param class-string $class Class FQN.
     *
     * @return bool
     */
    public function has(string $class): bool;
}
