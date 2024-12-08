<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Bakery\Helper;

use DI\Attribute\Inject;
use Illuminate\Database\Capsule\Manager as Capsule;
use PDOException;

/**
 * Database Test Trait. Include method to test the db connection.
 *
 * N.B.: Make use of the Database Capsule Manager and not the Connection alias
 * service, as connection might not be up to date if another command (setup:db)
 * has changed the db config, even if the service is set on the container.
 */
trait DatabaseTest
{
    #[Inject]
    protected Capsule $capsule;

    /**
     * Test database connection directly using PDO.
     *
     * @throws PDOException
     * @return bool         True if success
     */
    protected function testDB(): bool
    {
        try {
            $connectionName = $this->capsule->getDatabaseManager()->getDefaultConnection();
            $connection = $this->capsule->getConnection($connectionName);
            $connection->getPdo();
        } catch (PDOException $e) {
            $message = 'Could not connect to the database connection' . PHP_EOL;
            $message .= 'Exception: ' . $e->getMessage() . PHP_EOL . PHP_EOL;
            $message .= 'Please check your database configuration and/or google the exception shown above and run command again.';
            throw new PDOException($message, 0, $e);
        }

        return true;
    }
}
