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

use BadMethodCallException;
use UserFrosting\UniformResourceLocator\Exception\LocationNotFoundException;
use UserFrosting\UniformResourceLocator\Exception\StreamNotFoundException;

/**
 * The locator is used to find resources.
 */
interface ResourceLocatorInterface
{
    /**
     * Alias for findResource().
     *
     * @param string $uri
     *
     * @throws BadMethodCallException
     *
     * @return string|null
     */
    public function __invoke(string $uri): ?string;

    /**
     * Add an existing ResourceStream to the stream list.
     *
     * @param ResourceStreamInterface $stream
     *
     * @return static
     */
    public function addStream(ResourceStreamInterface $stream): static;

    /**
     * Returns true if uri is resolvable by using locator.
     *
     * @param string $uri
     *
     * @return bool
     */
    public function isStream(string $uri): bool;

    /**
     * Register a new stream.
     *
     * @param string               $scheme
     * @param string|string[]|null $paths  (default null). When using null path, the scheme will be used as a path
     * @param bool                 $shared (default false) Shared resources are not affected by locations
     *
     * @return static
     *
     * @deprecated Use `addStream` instead
     */
    public function registerStream(string $scheme, string|array|null $paths = null, bool $shared = false): static;

    /**
     * Unregister the specified stream.
     *
     * @param string $scheme The stream scheme
     *
     * @return static
     */
    public function removeStream(string $scheme): static;

    /**
     * Return all registered Streams for a specific scheme.
     * Return value is an array of ResourceStreamInterface.
     *
     * @param string $scheme The stream scheme
     *
     * @throws StreamNotFoundException If stream is not registered
     *
     * @return ResourceStreamInterface[]
     */
    public function getStream(string $scheme): array;

    /**
     * Return information about a all registered stream.
     * Return value is an array of array of ResourceStreamInterface
     * For example :
     *   'bar' => array(
     *      ResourceStreamInterfaceA
     *      ResourceStreamInterfaceB
     *   ),
     *   'foo' => array(
     *      ResourceStreamInterfaceC
     *   );.
     *
     * @return ResourceStreamInterface[][]
     */
    public function getStreams(): array;

    /**
     * Return a list of all the stream scheme registered.
     *
     * @return string[] An array of registered scheme => location
     */
    public function listSchemes(): array;

    /**
     * Returns true if a stream has been defined.
     *
     * @param string $scheme The stream scheme
     *
     * @return bool
     */
    public function schemeExists(string $scheme): bool;

    /**
     * Add an existing ResourceLocation instance to the location list.
     *
     * @param ResourceLocationInterface $location
     *
     * @return static
     */
    public function addLocation(ResourceLocationInterface $location): static;

    /**
     * Register a new location.
     *
     * @param string $name The location name
     * @param string $path The location base path (default null)
     *
     * @return static
     *
     * @deprecated Use `addLocation` instead
     */
    public function registerLocation(string $name, ?string $path = null): static;

    /**
     * Unregister the specified location.
     *
     * @param string $name The location name
     *
     * @return static
     */
    public function removeLocation(string $name): static;

    /**
     * Get a location instance based on it's name.
     *
     * @param string $name The location name
     *
     * @throws LocationNotFoundException If location is not registered
     *
     * @return ResourceLocationInterface
     */
    public function getLocation(string $name): ResourceLocationInterface;

    /**
     * Get a a list of all registered locations.
     *
     * @return ResourceLocationInterface[]
     */
    public function getLocations(): array;

    /**
     * Return a list of all the locations registered by name.
     *
     * @return string[] An array of registered name => location
     */
    public function listLocations(): array;

    /**
     * Returns true if a location has been defined.
     *
     * @param string $name The location name
     *
     * @return bool
     */
    public function locationExist(string $name): bool;

    /**
     * Return a resource instance.
     *
     * @param string $uri   Input URI to be searched (can be a file/path)
     * @param bool   $first Whether to return first path even if it doesn't exist.
     *
     * @return ResourceInterface|null Returns null if resource is not found
     */
    public function getResource(string $uri, bool $first = false): ?ResourceInterface;

    /**
     * Return a list of resources instances.
     *
     * @param string $uri Input URI to be searched (can be a file/path)
     * @param bool   $all Whether to return all paths even if they don't exist.
     *
     * @return ResourceInterface[] Array of Resources
     */
    public function getResources(string $uri, bool $all = false): array;

    /**
     * List all resources found at a given uri.
     * Same as listing all file in a directory, except here all topmost
     * resources will be returned when considering all locations.
     *
     * @param string $uri  Input URI to be searched (can be a uri/path ONLY)
     * @param bool   $all  If true, all resources will be returned, not only topmost ones
     * @param bool   $sort Set to true to sort results alphabetically by absolute path. Set to false to sort by absolute priority, highest location first. Default to true.
     *
     * @return ResourceInterface[] The resources list
     */
    public function listResources(string $uri, bool $all = false, bool $sort = true): array;

    /**
     * Find highest priority instance from a resource. Return the path for said resource.
     *
     * For example, if looking for a `test.json` resource, only the top priority
     * instance of `test.json` found will be returned.
     *
     * @param string $uri      Input URI to be searched (can be a file or directory)
     * @param bool   $absolute Whether to return absolute path.
     * @param bool   $all      Whether to include all paths, even if they don't exist.
     *
     * @return string|null The resource path, or null if not found resource
     */
    public function findResource(string $uri, bool $absolute = true, bool $all = false): ?string;

    /**
     * Find all instances from a resource. Return an array of paths for said resource.
     *
     * For example, if looking for a `test.json` resource, all instance
     * of `test.json` found will be listed.
     *
     * @param string $uri      Input URI to be searched (can be a file or directory)
     * @param bool   $absolute Whether to return absolute path.
     * @param bool   $all      Whether to return all paths, even if they don't exist.
     *
     * @return string[] An array of all the resources path
     */
    public function findResources(string $uri, bool $absolute = true, bool $all = false): array;

    /**
     * @return string
     */
    public function getBasePath(): string;
}
