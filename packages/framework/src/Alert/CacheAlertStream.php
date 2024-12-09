<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Alert;

use Illuminate\Cache\Repository as Cache;
use Illuminate\Cache\TaggedCache;
use UserFrosting\I18n\Translator;

/**
 * Implements a message stream for use between HTTP requests, with i18n
 * support via the Translator class using the cache system to store
 * the alerts. Note that the tags are added each time instead of the
 * constructor since the session_id can change when the user logs in or out.
 */
class CacheAlertStream extends AlertStream
{
    /**
     * Create a new message stream.
     *
     * @param string     $messagesKey Store the messages under this key
     * @param Translator $translator
     * @param Cache      $cache       Object We use the cache object so that added messages will automatically appear in the cache.
     * @param string     $tag         Cache tag id tied to the alert stream. Usually tied to the session ID.
     */
    public function __construct(
        protected string $messagesKey,
        protected Translator $translator,
        protected Cache $cache,
        protected string $tag,
    ) {
        parent::__construct($translator);
    }

    /**
     * {@inheritDoc}
     */
    protected function retrieveMessages(): array
    {
        if ($this->getCache()->has($this->messagesKey)) {
            $data = $this->getCache()->get($this->messagesKey);

            return (is_array($data)) ? $data : [];
        } else {
            return [];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function resetMessageStream(): void
    {
        $this->getCache()->forget($this->messagesKey);
    }

    /**
     * {@inheritDoc}
     */
    protected function storeMessage(array $message): void
    {
        $messages = $this->retrieveMessages();
        $messages[] = $message;

        $this->getCache()->forever($this->messagesKey, $messages);
    }

    /**
     * @return TaggedCache
     */
    protected function getCache(): TaggedCache
    {
        return $this->cache->tags('_s' . $this->tag);
    }
}
