<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error\Renderer;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Throwable;
use Twig\Error\LoaderError;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Core\Exceptions\Contracts\TwigRenderedException;
use UserFrosting\Sprinkle\Core\Util\Message\Message;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class PrettyPageRenderer implements ErrorRendererInterface
{
    public function __construct(
        protected Config $config,
        protected Twig $twig,
        protected Run $whoops,
        protected PrettyPageHandler $handler,
    ) {
        $this->whoops->appendHandler($handler);
    }

    /**
     * {@inheritDoc}
     */
    public function render(
        ServerRequestInterface $request,
        Throwable $exception,
        Message $userMessage,
        int $statusCode,
        bool $displayErrorDetails = false
    ): string {
        // Show Whoops page if error details is active
        if ($displayErrorDetails) {
            return $this->whoops->handleException($exception);
        }

        // Render Twig pretty page otherwise
        return $this->renderTwigPage($exception, $userMessage, $statusCode);
    }

    /**
     * Render a generic, user-friendly response without sensitive debugging information.
     *
     * @param Message $userMessage
     * @param int     $statusCode
     *
     * @return string
     */
    protected function renderTwigPage(Throwable $exception, Message $userMessage, int $statusCode): string
    {
        $payload = [
            'title'       => $userMessage->title,
            'description' => $userMessage->description,
            'status'      => $statusCode,
        ];

        if ($exception instanceof TwigRenderedException) {
            $page = $exception->getTemplate();
        } else {
            $format = strval($this->config->get('error.pages.status'));
            $page = sprintf($format, $statusCode);
        }

        try {
            $body = $this->twig->fetch($page, $payload);
        } catch (LoaderError $e) {
            $format = strval($this->config->get('error.pages.error'));
            $body = $this->twig->fetch($format, $payload);
        }

        return $body;
    }
}
