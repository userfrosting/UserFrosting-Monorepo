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
interface MailMessage
{
    /**
     * Gets the fully rendered text of the message body.
     *
     * @param mixed[] $params
     *
     * @return string
     */
    public function renderBody(array $params = []): string;

    /**
     * Gets the fully rendered text of the message subject.
     *
     * @param mixed[] $params
     *
     * @return string
     */
    public function renderSubject(array $params = []): string;

    /**
     * Add an email recipient.
     *
     * @param EmailRecipient $recipient
     *
     * @return static
     */
    public function addEmailRecipient(EmailRecipient $recipient): static;

    /**
     * Clears out all recipients for this message.
     *
     * @return static
     */
    public function clearRecipients(): static;

    /**
     * Set sender information for this message.
     *
     * This is a shortcut for calling setFromEmail, setFromName, setReplyEmail, and setReplyName.
     *
     * @param string[] $fromInfo An array containing 'email', 'name', 'reply_email', and 'reply_name'.
     *
     * @return static
     */
    public function from(array $fromInfo = []): static;

    /**
     * Get the sender email address.
     *
     * @return string
     */
    public function getFromEmail(): string;

    /**
     * Get the sender name.  Defaults to the email address if name is not set.
     *
     * @return string
     */
    public function getFromName(): string;

    /**
     * Get the list of recipients for this message.
     *
     * @return EmailRecipient[]
     */
    public function getRecipients(): array;

    /**
     * Get the 'reply-to' address for this message.  Defaults to the sender email.
     *
     * @return string
     */
    public function getReplyEmail(): string;

    /**
     * Get the 'reply-to' name for this message.  Defaults to the sender name.
     *
     * @return string
     */
    public function getReplyName(): string;

    /**
     * Set the sender email address.
     *
     * @param string $fromEmail
     *
     * @return static
     */
    public function setFromEmail(string $fromEmail): static;

    /**
     * Set the sender name.
     *
     * @param string|null $fromName
     *
     * @return static
     */
    public function setFromName(?string $fromName): static;

    /**
     * Set the sender 'reply-to' address.
     *
     * @param string|null $replyEmail
     *
     * @return static
     */
    public function setReplyEmail(?string $replyEmail): static;

    /**
     * Set the sender 'reply-to' name.
     *
     * @param string|null $replyName
     *
     * @return static
     */
    public function setReplyName(?string $replyName): static;
}
