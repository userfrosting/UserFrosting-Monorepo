<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Log;

use Monolog\Handler\HandlerInterface;
use Monolog\Logger as Monolog;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * General Monolog wrapper for easier dependency injection.
 *
 * @see https://github.com/Seldaek/monolog/pull/1861
 *
 * This class should be used as a base to create specific loggers.
 */
class Logger extends AbstractLogger
{
    protected LoggerInterface $logger;

    public function __construct(
        HandlerInterface $handler,
        string $channel = 'log',
    ) {
        $this->logger = new Monolog($channel, [$handler]);
    }

    /**
     * @param mixed              $level
     * @param string|\Stringable $message
     * @param mixed[]            $context
     */
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $this->logger->log($level, $message, $context);
    }
}
