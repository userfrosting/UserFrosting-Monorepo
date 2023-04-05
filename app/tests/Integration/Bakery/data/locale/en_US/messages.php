<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

return [
    'Bar'  => 'Foo',
    'test' => [
        '@TRANSLATION' => 'Test',
        'bbb'          => 'BBB',
        'ccc'          => 'CCC', // Overwritten by ""
        'ddd'          => 'ddd', // Overwritten by "DDD"
    ],
];
