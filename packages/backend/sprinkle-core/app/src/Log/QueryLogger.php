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

/**
 * Query Monolog wrapper.
 */
final class QueryLogger extends Logger implements QueryLoggerInterface
{
    public function __construct(HandlerInterface $handler)
    {
        parent::__construct($handler, 'query');
    }
}
