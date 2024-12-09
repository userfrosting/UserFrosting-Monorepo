<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Testing;

use DI\Container;
use DI\ContainerBuilder;

/**
 * Helper static method to create container stub for testing.
 */
class ContainerStub
{
    /**
     * Create a container Stub used for testing.
     * Optionally add definitions to load into builder.
     *
     * @codeCoverageIgnore
     *
     * @param mixed[] $definitions (default: []). See https://php-di.org/doc/php-definitions.html
     *
     * @return Container
     */
    public static function create(array $definitions = []): Container
    {
        $builder = new ContainerBuilder();
        $builder->addDefinitions($definitions);
        $builder->useAttributes(true);

        return $builder->build();
    }
}
