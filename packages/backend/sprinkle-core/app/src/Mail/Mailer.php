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

use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use UserFrosting\Sprinkle\Core\Log\MailLoggerInterface;

/**
 * Mailer Class.
 * A basic wrapper for sending template-based emails.
 */
class Mailer
{
    /**
     * @var MailLoggerInterface
     */
    protected MailLoggerInterface $logger;

    /**
     * @var PHPMailer
     */
    protected PHPMailer $phpMailer;

    /**
     * Create a new Mailer instance.
     *
     * @param MailLoggerInterface $logger    A Monolog logger, used to dump debugging info for SMTP server transactions.
     * @param mixed[]             $config    An array of configuration parameters for phpMailer.
     * @param PHPMailer|null      $phpMailer Instance of phpMailer. Set to null to instantiate it.
     *
     * @throws PHPMailerException Wrong mailer config value given.
     */
    public function __construct(MailLoggerInterface $logger, array $config = [], ?PHPMailer $phpMailer = null)
    {
        $this->logger = $logger;

        // 'true' tells PHPMailer to use exceptions instead of error codes
        $this->phpMailer = $phpMailer ?? new PHPMailer(true);

        // Configuration options
        $mailer = $config['mailer'] ?? '';
        match ($mailer) {
            'mail'     => $this->phpMailer->isMail(),
            'qmail'    => $this->phpMailer->isQmail(),
            'sendmail' => $this->phpMailer->isSendmail(),
            'smtp'     => $this->setupSmtp($config),
            default    => throw new PHPMailerException("'mailer' must be one of 'smtp', 'mail', 'qmail', or 'sendmail'."),
        };

        // Set any additional message-specific options
        // TODO: enforce which options can be set through this subarray
        if (isset($config['message_options'])) {
            $this->setOptions((array) $config['message_options']);
        }

        // Pass logger into phpMailer object
        $this->phpMailer->Debugoutput = function ($message, $level) {
            $this->logger->debug($message);
        };
    }

    /**
     * Get the underlying PHPMailer object.
     *
     * @return PHPMailer
     */
    public function getPhpMailer(): PHPMailer
    {
        return $this->phpMailer;
    }

    /**
     * Send a MailMessage message.
     *
     * Sends a single email to all recipients, as well as their CCs and BCCs.
     * Since it is a single-header message, recipient-specific template data will not be included.
     *
     * @param MailMessage $message
     * @param bool        $clearRecipients Set to true to clear the list of recipients in the message after calling send().  This helps avoid accidentally sending a message multiple times.
     *
     * @throws PHPMailerException The message could not be sent.
     */
    public function send(MailMessage $message, bool $clearRecipients = true): void
    {
        // Clone phpMailer so we don't have to reset it after sending.
        $phpMailer = clone $this->phpMailer;

        $phpMailer->From = $message->getFromEmail();
        $phpMailer->FromName = $message->getFromName();
        $phpMailer->addReplyTo($message->getReplyEmail(), $message->getReplyName());

        // Add all email recipients, as well as their CCs and BCCs
        foreach ($message->getRecipients() as $recipient) {
            $phpMailer->addAddress($recipient->getEmail(), $recipient->getName());

            // Add any CCs and BCCs
            foreach ($recipient->getCCs() as $cc) {
                $phpMailer->addCC($cc['email'], $cc['name']);
            }
            foreach ($recipient->getBCCs() as $bcc) {
                $phpMailer->addBCC($bcc['email'], $bcc['name']);
            }
        }

        $phpMailer->Subject = $message->renderSubject();
        $phpMailer->Body = $message->renderBody();

        // Try to send the mail.  Will throw an exception on failure.
        $phpMailer->send();

        // Clear recipients from the PHPMailer object for this iteration,
        // so that we can use the same object for other emails.
        $phpMailer->clearAllRecipients();

        // Clear out the MailMessage's internal recipient list
        if ($clearRecipients) {
            $message->clearRecipients();
        }
    }

    /**
     * Send a MailMessage message, sending a separate email to each recipient.
     *
     * If the message object supports message templates, this will render the template with the corresponding placeholder values for each recipient.
     *
     * @param MailMessage $message
     * @param bool        $clearRecipients Set to true to clear the list of recipients in the message after calling send().  This helps avoid accidentally sending a message multiple times.
     *
     * @throws PHPMailerException The message could not be sent.
     */
    public function sendDistinct(MailMessage $message, bool $clearRecipients = true): void
    {
        // Clone phpMailer so we don't have to reset it after sending.
        $phpMailer = clone $this->phpMailer;

        $phpMailer->From = $message->getFromEmail();
        $phpMailer->FromName = $message->getFromName();
        $phpMailer->addReplyTo($message->getReplyEmail(), $message->getReplyName());

        // Loop through email recipients, sending customized content to each one
        foreach ($message->getRecipients() as $recipient) {
            $phpMailer->addAddress($recipient->getEmail(), $recipient->getName());

            // Add any CCs and BCCs
            foreach ($recipient->getCCs() as $cc) {
                $phpMailer->addCC($cc['email'], $cc['name']);
            }
            foreach ($recipient->getBCCs() as $bcc) {
                $phpMailer->addBCC($bcc['email'], $bcc['name']);
            }

            $phpMailer->Subject = $message->renderSubject($recipient->getParams());
            $phpMailer->Body = $message->renderBody($recipient->getParams());

            // Try to send the mail.  Will throw an exception on failure.
            $phpMailer->send();

            // Clear recipients from the PHPMailer object for this iteration,
            // so that we can send a separate email to the next recipient.
            $phpMailer->clearAllRecipients();
        }

        // Clear out the MailMessage's internal recipient list
        if ($clearRecipients) {
            $message->clearRecipients();
        }
    }

    /**
     * Set option(s) on the underlying phpMailer object.
     *
     * @param mixed[] $options
     *
     * @return static
     */
    public function setOptions(array $options): static
    {
        if (isset($options['isHtml'])) {
            $this->phpMailer->isHTML((bool) $options['isHtml']);
        }

        foreach ($options as $name => $value) {
            $this->phpMailer->set($name, $value);
        }

        return $this;
    }

    /**
     * Setup SMTP config.
     *
     * @param mixed[] $config
     */
    protected function setupSmtp(array $config): void
    {
        $this->phpMailer->isSMTP();
        $this->phpMailer->Host = strval($config['host']);
        $this->phpMailer->Port = intval($config['port']);
        $this->phpMailer->SMTPAuth = (bool) $config['auth'];
        $this->phpMailer->SMTPSecure = strval($config['secure']);
        $this->phpMailer->Username = strval($config['username']);
        $this->phpMailer->Password = strval($config['password']);
        $this->phpMailer->SMTPDebug = intval($config['smtp_debug']);

        // Disable opportunistic encryption if secure is unset. This is
        // required if you have an incorrect or invalid SSL Certificate on
        // your SMTP host, but the server offers STARTTLS.
        if ($config['secure'] !== true) {
            $this->phpMailer->SMTPAutoTLS = false;
        }

        if (isset($config['smtp_options'])) {
            $this->phpMailer->SMTPOptions = (array) $config['smtp_options'];
        }
    }
}
