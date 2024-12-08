<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Listeners;

use Illuminate\Database\Events\QueryExecuted;
use UserFrosting\Sprinkle\Core\Log\QueryLoggerInterface;

/**
 * Event listener for the QueryExecuted event.
 */
class LogExecutedQuery
{
    public function __construct(protected QueryLoggerInterface $logger)
    {
    }

    /**
     * Handle the QueryExecuted event.
     *
     * @param QueryExecuted $query
     */
    public function __invoke(QueryExecuted $query): void
    {
        $this->logger->debug("Query executed on database [{$query->connectionName}]:", [
            'query'    => $query->sql,
            'bindings' => $query->bindings,
            'time'     => $query->time . ' ms',
        ]);
    }
}
