<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error\Renderer;

use Psr\Http\Message\ServerRequestInterface;
use Throwable;
use UserFrosting\Sprinkle\Core\Util\Message\Message;

/**
 * Default JSON Error Renderer.
 */
final class JsonRenderer implements ErrorRendererInterface
{
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
        $error = [
            'title'       => $userMessage->title,
            'description' => $userMessage->description,
            'status'      => $statusCode,
        ];

        if ($displayErrorDetails) {
            $error['exception'] = [];
            do {
                $error['exception'][] = $this->formatExceptionFragment($exception);
            } while ($exception = $exception->getPrevious());
        }

        return json_encode($error, JSON_PRETTY_PRINT);
    }

    /**
     * @param Throwable $e
     *
     * @return mixed[]
     */
    public function formatExceptionFragment(Throwable $e): array
    {
        return [
            'type'    => get_class($e),
            'code'    => $e->getCode(),
            'message' => $e->getMessage(),
            'file'    => $e->getFile(),
            'line'    => $e->getLine(),
        ];
    }
}
