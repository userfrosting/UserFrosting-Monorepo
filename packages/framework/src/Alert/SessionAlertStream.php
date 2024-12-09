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

use UserFrosting\I18n\Translator;
use UserFrosting\Session\Session;

/**
 * Implements a message stream for use between HTTP requests, with i18n support via the Translator class
 * Using the session storage to store the alerts.
 */
class SessionAlertStream extends AlertStream
{
    /**
     * Create a new message stream.
     *
     * @param string     $messagesKey Store the messages under this key
     * @param Session    $session     We use the session object so that added messages will automatically appear in the session.
     * @param Translator $translator
     */
    public function __construct(
        protected string $messagesKey,
        protected Translator $translator,
        protected Session $session,
    ) {
        parent::__construct($translator);
    }

    /**
     * {@inheritDoc}
     */
    protected function retrieveMessages(): array
    {
        $data = $this->session->get($this->messagesKey);

        return (is_array($data)) ? $data : [];
    }

    /**
     * {@inheritDoc}
     */
    public function resetMessageStream(): void
    {
        $this->session->set($this->messagesKey, []);
    }

    /**
     * {@inheritDoc}
     */
    protected function storeMessage(array $message): void
    {
        $messages = $this->retrieveMessages();
        $messages[] = $message;

        $this->session->set($this->messagesKey, $messages);
    }
}
