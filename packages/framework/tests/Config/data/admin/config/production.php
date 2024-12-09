<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

/*
 * Test configuration file for UserFrosting.
 */
return [
    'debug' => [
        'auth' => false,
    ],
    'site' => [
        'login' => [
            'enable_email' => false,
        ],
        'registration' => [
            'enabled' => false,
            'captcha' => false,
        ],
    ],
];
