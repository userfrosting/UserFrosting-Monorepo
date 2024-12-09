<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

/*
 * Environment configuration file.  Recursively merged in over the base default.php configuration file.
 */
return [
    'site' => [
        'analytics' => [
            'google' => [
                'enabled' => true,
            ],
        ],
        'debug' => [
            'ajax' => false,
            'info' => false,
        ],
    ],
];
