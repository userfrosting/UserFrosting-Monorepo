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
 * Generic PHP streamWrapper prototype interface.
 *
 * @see http://www.php.net/manual/class.streamwrapper.php
 */
interface StreamInterface
{
    /**
     * Support for closedir().
     *
     * @see http://php.net/manual/streamwrapper.dir-closedir.php
     *
     * @return bool Returns true on success or false on failure.
     */
    public function dir_closedir(): bool;

    /**
     * Support for opendir().
     *
     * @see http://php.net/manual/streamwrapper.dir-opendir.php
     *
     * @param string $path    A string containing the path/uri to the directory to open.
     * @param int    $options Unknown (parameter is not documented in PHP Manual).
     *
     * @return bool Returns true on success or false on failure.
     */
    public function dir_opendir(string $path, int $options): bool;

    /**
     * Support for readdir().
     *
     * @see http://php.net/manual/streamwrapper.dir-readdir.php
     *
     * @return string Should return string representing the next filename, or false if there is no next file. The return value will be casted to string.
     */
    public function dir_readdir(): string;

    /**
     * Support for rewinddir().
     *
     * @see http://php.net/manual/streamwrapper.dir-rewinddir.php
     *
     * @return bool Returns true on success or false on failure.
     */
    public function dir_rewinddir(): bool;

    /**
     * Support for mkdir().
     *
     * @see http://php.net/manual/streamwrapper.mkdir.php
     *
     * @param string $path    Directory which should be created.
     * @param int    $mode    The value passed to mkdir().
     * @param int    $options A bit mask of STREAM_REPORT_ERRORS and STREAM_MKDIR_RECURSIVE.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function mkdir(string $path, int $mode, int $options): bool;

    /**
     * Support for rename().
     *
     * @see http://php.net/manual/streamwrapper.rename.php
     *
     * @param string $path_from The URL to the current file.
     * @param string $path_to   The URL which the path_from should be renamed to.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function rename(string $path_from, string $path_to): bool;

    /**
     * Support for rmdir().
     *
     * @see http://php.net/manual/streamwrapper.rmdir.php
     *
     * @param string $path    The directory URL which should be removed.
     * @param int    $options A bitwise mask of values, such as STREAM_MKDIR_RECURSIVE.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function rmdir(string $path, int $options): bool;

    /**
     * Support for fclose().
     *
     * @see http://php.net/manual/streamwrapper.stream-close.php
     */
    public function stream_close(): void;

    /**
     * Support for feof().
     *
     * @see http://php.net/manual/streamwrapper.stream-eof.php
     *
     * @return bool Should return true if the read/write position is at the end of the stream and if no more data is available to be read, or false otherwise.
     */
    public function stream_eof(): bool;

    /**
     * Support for fflush().
     *
     * @see http://php.net/manual/streamwrapper.stream-flush.php
     *
     * @return bool Should return true if the cached data was successfully stored (or if there was no data to store), or false if the data could not be stored.
     */
    public function stream_flush(): bool;

    /**
     * Support for flock().
     *
     * @see http://php.net/manual/streamwrapper.stream-lock.php
     *
     * @param int $operation LOCK_SH, LOCK_EX, LOCK_UN, LOCK_NB
     *
     * @return bool Returns true on success or false on failure.
     */
    public function stream_lock(int $operation): bool;

    /**
     * Support for touch(), chmod(), chown(), chgrp().
     *
     * @see http://php.net/manual/en/streamwrapper.stream-metadata.php
     *
     * @param string $path
     * @param int    $option
     * @param mixed  $value
     *
     * @return bool
     */
    public function stream_metadata(string $path, int $option, mixed $value): bool;

    /**
     * Support for fopen(), file_get_contents(), file_put_contents() etc.
     *
     * @see http://php.net/manual/streamwrapper.stream-open.php
     *
     * @param string $path        Specifies the URL that was passed to the original function.
     * @param string $mode        The mode used to open the file, as detailed for fopen().
     * @param int    $options     Holds additional flags set by the streams API. It can hold one or more of the following values OR'd together.
     * @param string $opened_path If the path is opened successfully, and STREAM_USE_PATH is set in options, opened_path should be set to the full path of the file/resource that was actually opened.
     *
     * @return bool Returns Returns true on success or false on failure.
     */
    public function stream_open(string $path, string $mode, int $options, ?string &$opened_path): bool;

    /**
     * Support for fread(), file_get_contents() etc.
     *
     * @see http://php.net/manual/streamwrapper.stream-read.php
     *
     * @param int<1, max> $count How many bytes of data from the current position should be returned.
     *
     * @return string|false If there are less than count bytes available, return as many as are available. If no more data is available, return either false or an empty string.
     */
    public function stream_read(int $count): string|false;

    /**
     * Support for fseek().
     *
     * @see http://php.net/manual/streamwrapper.stream-seek.php
     *
     * @param int $offset The stream offset to seek to.
     * @param int $whence SEEK_SET, SEEK_CUR, or SEEK_END.
     *
     * @return bool Return true if the position was updated, false otherwise.
     */
    public function stream_seek(int $offset, int $whence = SEEK_SET): bool;

    /**
     * Support for fstat().
     *
     * @see http://php.net/manual/streamwrapper.stream-stat.php
     *
     * @return mixed[]|false An array with file status, or FALSE in case of an error - see fstat()
     */
    public function stream_stat(): array|false;

    /**
     * Support for ftell().
     *
     * @see http://php.net/manual/streamwrapper.stream-tell.php
     *
     * @return int The current position of the stream.
     */
    public function stream_tell(): int;

    /**
     * Support for fwrite(), file_put_contents() etc.
     *
     * @see http://php.net/manual/streamwrapper.stream-write.php
     *
     * @param string $data The string to be written.
     *
     * @return int The number of bytes that were successfully stored, or 0 if none could be stored.
     */
    public function stream_write(string $data): int;

    /**
     * Support for unlink().
     *
     * @see http://php.net/manual/streamwrapper.unlink.php
     *
     * @param string $path The file URL which should be deleted.
     *
     * @return bool Returns true on success or false on failure.
     */
    public function unlink(string $path): bool;

    /**
     * Support for stat().
     *
     * @see http://php.net/manual/streamwrapper.url-stat.php
     *
     * @param string $path  A string containing the URI to get information about.
     * @param int    $flags A bit mask of STREAM_URL_STAT_LINK and STREAM_URL_STAT_QUIET.
     *
     * @return mixed[]|false An array with file status, or FALSE in case of an error - see fstat()
     */
    public function url_stat(string $path, int $flags): array|false;

    /**
     * Support for stream_set_option
     *  - stream_set_blocking()
     *  - stream_set_timeout()
     *  - stream_set_write_buffer().
     *
     * @see http://php.net/manual/streamwrapper.stream-set-option.php
     * @see https://www.php.net/manual/en/migration74.incompatible.php
     *
     * @param int $option
     * @param int $arg1
     * @param int $arg2
     *
     * @return bool
     */
    public function stream_set_option(int $option, int $arg1, int $arg2);
}
