<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Log;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use UserFrosting\Sprinkle\Core\Log\Logger;

/**
 * Monolog alias for dependency injection.
 */
final class AuthLogger extends Logger implements AuthLoggerInterface
{
    public function __construct(
        StreamHandler $handler,
        LineFormatter $formatter,
    ) {
        $formatter->setJsonPrettyPrint(true);
        $handler->setFormatter($formatter);

        parent::__construct($handler, 'auth');
    }
}
