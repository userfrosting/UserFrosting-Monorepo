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

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Database Test Trait. Include method to test the db connection.
 */
class DbParamTester
{
    /**
     * Test database param.
     *
     * @param string[] $dbParams Database params
     *
     * @throws \PDOException If connection failed
     *
     * @return true Return true if db is successful
     *
     * @codeCoverageIgnore
     */
    public function test(array $dbParams): bool
    {
        // Setup a new db connection
        $capsule = new Capsule();
        $capsule->addConnection($dbParams);

        // Test the db connection.
        $conn = $capsule->getConnection();
        $conn->getPdo();

        return true;
    }
}
