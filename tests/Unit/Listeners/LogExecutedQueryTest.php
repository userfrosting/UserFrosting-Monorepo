<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit\ServicesProvider;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\SQLiteConnection;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Core\Listeners\LogExecutedQuery;
use UserFrosting\Sprinkle\Core\Log\QueryLogger;

/**
 * Integration tests for `alerts` service.
 * Check to see if service returns what it's supposed to return
 */
class LogExecutedQueryTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testLogExecutedQuery(): void
    {
        // Set some data
        $string = 'Query executed on database [foobar]:';
        $sql = "select * from 'users' where name = ?";
        $bindings = ['foobar'];
        $time = '1.12';
        $data = [
            'query'    => $sql,
            'bindings' => $bindings,
            'time'     => $time . ' ms',
        ];

        // Create QueryExecuted Event Mock
        $connection = Mockery::mock(SQLiteConnection::class)
            ->shouldReceive('getName')->once()->andReturn('foobar')
            ->getMock();
        $event = new QueryExecuted($sql, $bindings, $time, $connection);

        // Create Logger mocks
        $logger = Mockery::mock(QueryLogger::class)
            ->shouldReceive('debug')->with($string, $data)->once()
            ->getMock();

        $listener = new LogExecutedQuery($logger);
        $listener($event);
    }
}
