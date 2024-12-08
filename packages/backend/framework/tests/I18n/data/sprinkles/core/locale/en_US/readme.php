<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

return [
    'COMPLEX_STRING' => "There's {{child}} and {{adult}} in the {{color}} {{car}}",
    'X_CHILD'        => [
        '@PLURAL' => 'nb_child',
        0         => 'no children',
        1         => 'a child',
        2         => '{{plural}} children',
    ],
    'X_ADULT' => [
        '@PLURAL' => 'nb_adult',
        0         => 'no adults',
        1         => 'an adult',
        2         => '{{nb_adult}} adults',
    ],
    'CAR' => [
        'FULL_MODEL' => '{{make}} {{model}} {{year}}',
    ],

    'COMPLEX_STRING2' => "There's {{&X_CHILD}} and {{&X_ADULT}} in the {{color}} {{&CAR.FULL_MODEL}}",

    'NON_STRING' => 1,
];
