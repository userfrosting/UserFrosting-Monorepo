<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Mail;

/**
 * Represents a basic mail message, containing a static subject and body.
 */
final class StaticMailMessage extends AbstractMailMessage implements MailMessage
{
    /**
     * Create a new MailMessage instance.
     *
     * @param string $subject The body for this message.
     * @param string $body    The subject for this message.
     */
    public function __construct(
        protected string $subject = '',
        protected string $body = '',
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function renderBody(array $params = []): string
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
     */
    public function renderSubject(array $params = []): string
    {
        return $this->subject;
    }

    /**
     * Set the text of the message subject.
     *
     * @param string $subject
     *
     * @return static
     */
    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set the text of the message body.
     *
     * @param string $body
     */
    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }
}
