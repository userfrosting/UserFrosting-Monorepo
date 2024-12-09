<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error;

use UserFrosting\Config\Config;
use UserFrosting\Event\AppInitiatedEvent;

/**
 * Register the ShutdownHandler.
 */
class RegisterShutdownHandler
{
    public function __construct(
        protected Config $config,
        protected ShutdownHandler $shutdownHandler,
    ) {
    }

    public function __invoke(AppInitiatedEvent $app): void
    {
        // Display PHP fatal errors natively.
        $displayErrorsNative = boolval($this->config->get('php.display_errors_native'));
        ini_set('display_errors', (string) $displayErrorsNative);

        // Register custom shutdown function
        if (!$displayErrorsNative) {
            $this->shutdownHandler->register();
        }

        // Log PHP fatal errors
        $logErrors = strval($this->config->get('php.log_errors'));
        ini_set('log_errors', $logErrors);

        // Configure error-reporting level
        $errorReporting = intval($this->config->get('php.error_reporting'));
        error_reporting($errorReporting);

        // Configure time zone
        $timezone = strval($this->config->get('php.timezone'));
        date_default_timezone_set($timezone);
    }
}
