<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Log;

use Monolog\Handler\HandlerInterface;

/**
 * Error Monolog wrapper.
 */
final class ErrorLogger extends Logger implements ErrorLoggerInterface
{
    public function __construct(HandlerInterface $handler)
    {
        parent::__construct($handler, 'errors');
    }
}
