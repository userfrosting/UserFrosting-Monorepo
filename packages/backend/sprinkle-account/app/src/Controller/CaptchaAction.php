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
use UserFrosting\Config\Config;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Core\Util\Captcha;

/**
 * Generate a random captcha, store it to the session, and return the captcha image.
 *
 * Middleware: none
 * Route: /account/captcha
 * Route Name: account.captcha
 * Request type: GET
 */
class CaptchaAction
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Session $session,
        protected Config $config,
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
        $payload = $this->handle($request);
        $response->getBody()->write($payload);

        return $response->withStatus(200)
                        ->withHeader('Content-Type', 'image/png;base64');
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
        $key = $this->config->getString('session.keys.captcha', 'account.captcha');
        $captcha = new Captcha($this->session, $key);
        $captcha->generateRandomCode();

        return $captcha->getImage();
    }
}
