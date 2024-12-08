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

use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;

/**
 * Implements an alert stream for use between HTTP requests, with i18n support via the Translator class.
 */
abstract class AlertStream
{
    /**
     * Create a new message stream.
     *
     * @param Translator $translator
     */
    public function __construct(
        protected Translator $translator
    ) {
    }

    /**
     * Adds a raw text message to the cache message stream.
     *
     * @param string      $type         The type of message, indicating how it will be styled when outputted. Should be set to "success", "danger", "warning", or "info".
     * @param string      $message      The message to be added to the message stream.
     * @param mixed[]|int $placeholders An optional hash of placeholder names => placeholder values to substitute into the translated message.
     *
     * @return static
     */
    public function addMessage(string $type, string $message, array|int $placeholders = []): static
    {
        $this->storeMessage([
            'type'         => $type,
            'message'      => $message,
            'placeholders' => $placeholders,
        ]);

        return $this;
    }

    /**
     * Adds a text message to the cache message stream, translated into the currently selected language.
     *
     * @param string      $type         The type of message, indicating how it will be styled when outputted.  Should be set to "success", "danger", "warning", or "info".
     * @param string      $message      The message id for the message to be added to the message stream.
     * @param mixed[]|int $placeholders An optional hash of placeholder names => placeholder values to substitute into the translated message.
     *
     * @return static
     *
     * @deprecated 5.1 Use `addMessage` instead.
     */
    public function addMessageTranslated(string $type, string $message, array|int $placeholders = []): static
    {
        return $this->addMessage($type, $message, $placeholders);
    }

    /**
     * Get the messages and then clear the message stream.
     *
     * This function does the same thing as `messages()`, except that it also clears all messages afterwards.
     * This is useful, because typically we don't want to view the same messages more than once.
     * Returns an array of messages, each of which is itself an array containing "type" and "message" fields.
     *
     * @return array<int, array{type: string, message: string, placeholders: mixed[]|int}>
     */
    public function getAndClearMessages(): array
    {
        $messages = $this->messages();
        $this->resetMessageStream();

        return $messages;
    }

    /**
     * Get the messages from this message stream.
     *
     * @return array<int, array{type: string, message: string, placeholders: mixed[]|int}>
     */
    public function messages(): array
    {
        $messages = $this->retrieveMessages();
        $messages = $this->translateMessages($messages);

        return $messages;
    }

    /**
     * Add error messages from a ServerSideValidator object to the message stream.
     *
     * @param ServerSideValidator $validator
     *
     * @deprecated 5.1 This should be manually done in code.
     */
    public function addValidationErrors(ServerSideValidator $validator): void
    {
        // @phpstan-ignore-next-line errors() will be array since no argument is used
        foreach ($validator->errors() as $idx => $field) {
            foreach ($field as $eidx => $error) {
                $this->addMessage('danger', $error);
            }
        }
    }

    /**
     * Translates messages that have a message id instead of a message.
     *
     * @param array<int, array{type: string, message: string, placeholders: mixed[]|int}> $messages
     *
     * @return array<int, array{type: string, message: string, placeholders: mixed[]|int}>
     */
    protected function translateMessages(array $messages): array
    {
        $translated = [];
        foreach ($messages as $message) {
            $message['message'] = $this->translator->translate($message['message'], $message['placeholders']);
            $translated[] = $message;
        }

        return $translated;
    }

    /**
     * Get the messages from this message stream.
     *
     * @return array<int, array{type: string, message: string, placeholders: mixed[]|int}> An array of messages, each of which is itself an array containing "type" and "message" fields.
     */
    abstract protected function retrieveMessages(): array;

    /**
     * Clear all messages from this message stream.
     */
    abstract public function resetMessageStream(): void;

    /**
     * Save messages to the stream.
     *
     * @param array{type: string, message: string, placeholders: mixed[]|int} $message
     */
    abstract protected function storeMessage(array $message): void;
}
