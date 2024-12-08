<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Csrf;

use ArrayObject;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use Slim\Csrf\Guard;
use UserFrosting\Config\Config;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Core\Exceptions\CsrfMissingException;

/**
 * Custom Slim Csrf Provider implementation.
 *
 * Allow injection of the Slim App, use of our session storage, custom error
 * handling, blacklist from the config service, etc.
 */
class CsrfGuard extends Guard
{
    /**
     * Overwrites the default constructor to inject dependencies.
     *
     * @param Config             $config
     * @param Session            $session
     * @param App<\DI\Container> $app
     */
    public function __construct(
        protected Config $config,
        Session $session,
        App $app,
    ) {
        $csrfKey = $config->getString('session.keys.csrf', 'site.csrf');

        // Workaround so that we can pass storage into CSRF guard.
        // If we tried to directly pass the indexed portion of `session` (for example, $ci->session['site.csrf']),
        // we would get an 'Indirect modification of overloaded element of UserFrosting\Session\Session' error.
        // If we tried to assign an array and use that, PHP would only modify the local variable, and not the session.
        // Since ArrayObject is an object, PHP will modify the object itself, allowing it to persist in the session.
        if (!$session->has($csrfKey)) {
            $session->set($csrfKey, new ArrayObject());
        }
        $csrfStorage = $session->get($csrfKey);

        $onFailure = function ($request, $response) {
            throw new CsrfMissingException('The CSRF code was invalid or not provided.');
        };

        parent::__construct(
            $app->getResponseFactory(),
            $config->getString('csrf.name', 'csrf'),
            $csrfStorage,
            $onFailure,
            $config->getInt('csrf.storage_limit', 200),
            $config->getInt('csrf.strength', 16),
            $config->getBool('csrf.persistent_token', true)
        );
    }

    /**
     * {@inheritDoc}
     *
     * @phpstan-ignore-next-line
     */
    public function setStorage(&$storage = null): self
    {
        if ($storage instanceof ArrayObject) {
            $this->storage = &$storage;

            return $this;
        }

        // @phpstan-ignore-next-line
        return parent::setStorage($storage);
    }

    /**
     * {@inheritdoc}
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $path = $request->getUri()->getPath();
        $method = $request->getMethod();

        // Normalize path to always have a leading slash
        $path = '/' . ltrim($path, '/');

        // Normalize method to uppercase.
        $method = strtoupper($method);

        /** @var array<string,string[]> */
        $csrfBlacklist = $this->config->getArray('csrf.blacklist');
        $isBlacklisted = false;

        // Go through the blacklist and determine if the path and method match any of the blacklist entries.
        foreach ($csrfBlacklist as $pattern => $methods) {
            $methods = array_map('strtoupper', $methods);
            if (in_array($method, $methods, true) && $pattern !== '' && preg_match('~' . $pattern . '~', $path) == true) {
                $isBlacklisted = true;
                break;
            }
        }

        if ($isBlacklisted === false) {
            return parent::process($request, $handler);
        }

        return $handler->handle($request);
    }
}
