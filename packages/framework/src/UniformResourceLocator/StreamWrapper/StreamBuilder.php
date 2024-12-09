<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\UniformResourceLocator\StreamWrapper;

use InvalidArgumentException;

/**
 * Class StreamBuilder.
 */
class StreamBuilder
{
    /**
     * StreamBuilder constructor.
     *
     * @param string[] $items Streams to register (as $scheme => $handler)
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $scheme => $handler) {
            $this->add($scheme, $handler);
        }
    }

    /**
     * @param string $scheme
     * @param string $handler
     *
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function add(string $scheme, string $handler): static
    {
        if (!is_subclass_of($handler, StreamInterface::class)) {
            throw new InvalidArgumentException("Stream '{$scheme}' has unknown or invalid type.");
        }

        if (!@stream_wrapper_register($scheme, $handler)) {
            throw new InvalidArgumentException("Stream '{$scheme}' could not be initialized or has already been initialized.");
        }

        return $this;
    }

    /**
     * @param string $scheme
     *
     * @return static
     */
    public function remove(string $scheme): static
    {
        if (in_array($scheme, $this->getStreams(), true)) {
            stream_wrapper_unregister($scheme);
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getStreams(): array
    {
        return stream_get_wrappers();
    }

    /**
     * @param string $scheme
     *
     * @return bool
     */
    public function isStream(string $scheme): bool
    {
        return in_array($scheme, $this->getStreams(), true);
    }
}
