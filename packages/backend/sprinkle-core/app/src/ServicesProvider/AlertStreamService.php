<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Illuminate\Cache\Repository as Cache;
use Psr\Container\ContainerInterface;
use UserFrosting\Alert\AlertStream;
use UserFrosting\Alert\CacheAlertStream;
use UserFrosting\Alert\SessionAlertStream;
use UserFrosting\Config\Config;
use UserFrosting\I18n\Translator;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Session\Session;
use UserFrosting\Sprinkle\Core\Exceptions\BadConfigException;

/**
 * Flash messaging service.
 *
 * Persists error/success messages between requests in the session.
 *
 * @throws BadConfigException If alert handler is not supported
 */
class AlertStreamService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            /**
             * Select AlertStream based on Config.
             *
             * @throws BadConfigException
             */
            AlertStream::class => function (ContainerInterface $ci, Config $config) {
                $storage = $config->getString('alert.storage');

                return match ($storage) {
                    'cache'   => $ci->get(CacheAlertStream::class),
                    'session' => $ci->get(SessionAlertStream::class),
                    default   => throw new BadConfigException("Bad alert storage handler type '$storage' specified in configuration file."),
                };
            },

            CacheAlertStream::class => function (Config $config, Translator $translator, Cache $cache, Session $session) {
                $sessionId = $session->getId();

                return new CacheAlertStream(
                    $config->getString('alert.key', 'site.alerts'),
                    $translator,
                    $cache,
                    ($sessionId === false) ? '' : $sessionId
                );
            },

            SessionAlertStream::class => function (Config $config, Translator $translator, Session $session) {
                return new SessionAlertStream(
                    $config->getString('alert.key', 'site.alerts'),
                    $translator,
                    $session
                );
            },
        ];
    }
}
