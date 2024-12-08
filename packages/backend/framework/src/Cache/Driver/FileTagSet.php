<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Cache\Driver;

use Illuminate\Cache\TagSet;

/**
 * Custom file based cache driver with supports for Tags
 * Inspired by unikent/taggedFileCache.
 */
class FileTagSet extends TagSet
{
    /**
     * The cache store implementation.
     *
     * @var TaggableFileStore
     */
    // @phpstan-ignore-next-line - This is the correct type
    protected $store;

    /**
     * @var string Driver name
     */
    protected static $driver = 'tfile';

    /**
     * Create a new TagSet instance.
     *
     * @param TaggableFileStore $store
     * @param string[]          $names
     */
    public function __construct(TaggableFileStore $store, array $names = [])
    {
        parent::__construct($store, $names);
    }

    /**
     * Get the tag identifier key for a given tag.
     *
     * @param string $name
     *
     * @return string
     */
    public function tagKey($name)
    {
        return $this->store->tagRepository . $this->store->separator . preg_replace('/[^\w\s\d\-_~,;\[\]\(\).]/', '~', $name);
    }

    /**
     * Reset the tag and return the new tag identifier.
     *
     * @param string $name
     *
     * @return string
     */
    public function resetTag($name)
    {
        // Get the old tagId. When resetting a tag, a new id will be create
        $oldID = $this->store->get($this->tagKey($name));

        if ($oldID !== false) {
            $oldIDArray = is_array($oldID) ? $oldID : [$oldID];
            foreach ($oldIDArray as $id) {
                $this->store->flushOldTag($id);
            }
        }

        return parent::resetTag($name);
    }

    /**
     * Get a unique namespace that changes when any of the tags are flushed.
     * N.B.: Default Laravel separator is `|`, but it will result in
     * "no such file or directory" on Windows. So we use our own.
     *
     * @return string
     */
    public function getNamespace()
    {
        return implode('+', $this->tagIds());
    }
}
