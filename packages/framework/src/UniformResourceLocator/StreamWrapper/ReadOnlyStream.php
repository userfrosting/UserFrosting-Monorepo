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

/**
 * Implements Read Only Streams.
 */
class ReadOnlyStream extends Stream
{
    /**
     * {@inheritDoc}
     */
    public function stream_open(string $uri, string $mode, int $options, ?string &$opened_path): bool
    {
        if (!in_array($mode, ['r', 'rb', 'rt'], true)) {
            trigger_error(sprintf('stream_open() write modes not allowed for %s', $uri));

            return false;
        }

        return parent::stream_open($uri, $mode, $options, $opened_path);
    }

    /**
     * {@inheritDoc}
     */
    public function stream_lock(int $operation): bool
    {
        // Disallow exclusive lock or non-blocking lock requests
        if (!in_array($operation, [LOCK_SH, LOCK_UN, LOCK_SH | LOCK_NB], true)) {
            trigger_error('stream_lock() exclusive lock operations not allowed for readonly stream', E_USER_WARNING);

            return false;
        }

        return parent::stream_lock($operation);
    }

    /**
     * {@inheritDoc}
     */
    public function stream_metadata(string $uri, int $option, mixed $value): bool
    {
        trigger_error(sprintf('stream_metadata() not allowed for readonly %s', $uri));

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function stream_write(string $data): int
    {
        trigger_error('stream_write() not allowed for readonly resource');

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function unlink(string $uri): bool
    {
        trigger_error(sprintf('unlink() not allowed for readonly %s', $uri));

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function rename(string $path_from, string $path_to): bool
    {
        trigger_error(sprintf('rename() not allowed for readonly %s', $path_from));

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function mkdir(string $path, int $mode, int $options): bool
    {
        trigger_error(sprintf('mkdir() not allowed for readonly %s', $path));

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function rmdir(string $path, int $options): bool
    {
        trigger_error(sprintf('rmdir() not allowed for readonly %s', $path));

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function stream_set_option(int $option, int $arg1, int $arg2)
    {
        return false;
    }
}
