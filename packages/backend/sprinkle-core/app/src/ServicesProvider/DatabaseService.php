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

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Connection;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Schema\Builder;
use Illuminate\Events\Dispatcher;
use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Listeners\LogExecutedQuery;

/*
 * Initialize Eloquent Capsule, which provides the database layer for UF.
 *
 * @todo construct the individual objects rather than using the facade
 * @return \Illuminate\Database\Capsule\Manager
*/
class DatabaseService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            Capsule::class => function (Config $config, LogExecutedQuery $logger) {
                $capsule = new Capsule();

                // Add each defined connection in the config
                foreach ($config->getArray('db.connections', []) as $name => $dbConfig) {
                    $capsule->addConnection($dbConfig, $name);
                }

                // Set default connection
                $defaultConnection = $config->getString('db.default', '');
                $capsule->getDatabaseManager()->setDefaultConnection($defaultConnection);

                // Set Event Dispatcher
                $queryEventDispatcher = new Dispatcher();
                $capsule->setEventDispatcher($queryEventDispatcher);

                // Register as global connection
                $capsule->setAsGlobal();

                // Start Eloquent
                $capsule->bootEloquent();

                // Listen to QueryExecuted event and send debug to logger if required by config
                // N.B.: Using [$logger, '__invoke'] because `listen` expects a callable
                if ($config->getBool('debug.queries') === true) {
                    $queryEventDispatcher->listen(QueryExecuted::class, [$logger, '__invoke']);
                }

                return $capsule;
            },

            Builder::class => function (Connection $connection) {
                return $connection->getSchemaBuilder();
            },

            /**
             * WARNING: This service might not be updated if the connection is
             * dynamically changed, as the return value is cached by PHP-DI. It
             * is recommended to inject "Capsule" instead, and use the
             * "getConnection()" method to get the connection.
             */
            Connection::class => function (Capsule $db) {
                $connection = $db->getDatabaseManager()->getDefaultConnection();

                return $db->getConnection($connection);
            },

            // Alias for ConnectionInterface
            ConnectionInterface::class => \DI\get(Connection::class),
        ];
    }
}
