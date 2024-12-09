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
abstract class AbstractMailMessage implements MailMessage
{
    /**
     * @var string The current sender email address.
     */
    protected string $fromEmail = '';

    /**
     * @var string|null The current sender name.
     */
    protected ?string $fromName = null;

    /**
     * @var EmailRecipient[] A list of recipients for this message.
     */
    protected array $recipients = [];

    /**
     * @var string|null The current reply-to email.
     */
    protected ?string $replyEmail = null;

    /**
     * @var string|null The current reply-to name.
     */
    protected ?string $replyName = null;

    /**
     * {@inheritDoc}
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * {@inheritDoc}
     */
    public function addEmailRecipient(EmailRecipient $recipient): static
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function clearRecipients(): static
    {
        $this->recipients = [];

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function from(array $fromInfo = []): static
    {
        $this->setFromEmail(isset($fromInfo['email']) ? $fromInfo['email'] : '');
        $this->setFromName(isset($fromInfo['name']) ? $fromInfo['name'] : null);
        $this->setReplyEmail(isset($fromInfo['reply_email']) ? $fromInfo['reply_email'] : null);
        $this->setReplyName(isset($fromInfo['reply_name']) ? $fromInfo['reply_name'] : null);

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFromEmail(): string
    {
        return $this->fromEmail;
    }

    /**
     * {@inheritDoc}
     */
    public function getFromName(): string
    {
        return $this->fromName ?? $this->getFromEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getReplyEmail(): string
    {
        return $this->replyEmail ?? $this->getFromEmail();
    }

    /**
     * {@inheritDoc}
     */
    public function getReplyName(): string
    {
        return $this->replyName ?? $this->getFromName();
    }

    /**
     * {@inheritDoc}
     */
    public function setFromEmail(string $fromEmail): static
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setFromName(?string $fromName): static
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setReplyEmail(?string $replyEmail): static
    {
        $this->replyEmail = $replyEmail;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setReplyName(?string $replyName): static
    {
        $this->replyName = $replyName;

        return $this;
    }
}
