<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

return [
    'Foo'  => 'Bar',
    'test' => [
        'aaa' => 'AAA',
        'ccc' => '', // Overwrites "CCC"
        'ddd' => 'DDD', // Overwrites "ddd"
    ],
];
