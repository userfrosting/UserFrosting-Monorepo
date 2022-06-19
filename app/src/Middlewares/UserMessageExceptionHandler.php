<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Middlewares;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use UserFrosting\Alert\AlertStream;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\UserMessageException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Route Middleware to send UserMessageException to the alert stream.
 */
class UserMessageExceptionHandler implements MiddlewareInterface
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected AlertStream $alert,
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (UserMessageException $e) {
            $title = $this->translateExceptionPart($e->getTitle());
            $description = $this->translateExceptionPart($e->getDescription());
            $this->alert->addMessage('danger', "$title: $description");

            throw $e;
        }
    }

    /**
     * Translate a string or UserMessage to a string.
     *
     * @param string|UserMessage $message
     *
     * @return string
     */
    protected function translateExceptionPart(string|UserMessage $message): string
    {
        if ($message instanceof UserMessage) {
            return $this->translator->translate($message->message, $message->parameters);
        }

        return $this->translator->translate($message);
    }
}
