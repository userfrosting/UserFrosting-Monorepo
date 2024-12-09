<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Sprinkle\Core\Throttle\ThrottlerDelayException;
use UserFrosting\Sprinkle\Core\Util\Util;

/**
 * Suggest an available username for a specified first/last name.
 *
 * Be careful how you consume this data - it has not been escaped and contains
 * untrusted user-supplied content. For example, if you plan to insert it into
 * an HTML DOM, you must escape it on the client side (or use client-side
 * templating).
 *
 * Middleware: none
 * Route: /account/suggest-username
 * Route Name: account.suggestUsername
 * Request type: GET
 */
class SuggestUsernameAction
{
    protected int $maxLength = 50;
    protected int $maxTries = 10;
    protected string $throttlerSlug = 'suggest_username';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Throttler $throttler,
        protected UserInterface $userModel,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $payload = [
            'user_name' => $this->handle($request),
        ];
        $payload = json_encode($payload, JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function handle(Request $request): string
    {
        $this->throttle();
        $this->throttler->logEvent($this->throttlerSlug);

        return $this->randomUniqueUsername();
    }

    /**
     * Throttle requests.
     */
    protected function throttle(): void
    {
        $delay = $this->throttler->getDelay($this->throttlerSlug);
        if ($delay > 0) {
            $e = new ThrottlerDelayException();
            $e->setDelay($delay);

            throw $e;
        }
    }

    protected function randomUniqueUsername(): string
    {
        for ($n = 1; $n <= 3; $n++) {
            for ($m = 0; $m < 10; $m++) {
                // Generate a random phrase with $n adjectives
                $suggestion = Util::randomPhrase($n, $this->maxLength, $this->maxTries, '.');
                if ($this->userModel->firstWhere('user_name', $suggestion) === null) {
                    return $suggestion;
                }
            }
        }

        return '';
    }
}
