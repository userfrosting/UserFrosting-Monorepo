<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Log\DebugLogger;
use UserFrosting\Sprinkle\Core\Log\DebugLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\ErrorLogger;
use UserFrosting\Sprinkle\Core\Log\ErrorLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\MailLogger;
use UserFrosting\Sprinkle\Core\Log\MailLoggerInterface;
use UserFrosting\Sprinkle\Core\Log\QueryLogger;
use UserFrosting\Sprinkle\Core\Log\QueryLoggerInterface;

class LoggersService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            DebugLoggerInterface::class => \DI\autowire(DebugLogger::class),
            ErrorLoggerInterface::class => \DI\autowire(ErrorLogger::class),
            MailLoggerInterface::class  => \DI\autowire(MailLogger::class),
            QueryLoggerInterface::class => \DI\autowire(QueryLogger::class),

            // Define formatter with `allowInlineLineBreaks` by default
            LineFormatter::class => \DI\create()->constructor(null, null, true),

            // Define common StreamHandler with our log path from config
            StreamHandler::class => function (Config $config) {
                return new StreamHandler($config->getString('logs.path', 'logs://userfrosting.log'));
            },
        ];
    }
}
