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
        'auth' => true,
    ],
    'site' => [
        'login' => [
            'enable_email' => true,
        ],
        'registration' => [
            'enabled'                    => true,
            'captcha'                    => true,
            'require_email_verification' => true,
            'user_defaults'              => [
                'locale' => 'en_US',
                'group'  => 'terran',
                // Default roles for newly registered users
                'roles' => [
                    'user' => true,
                ],
            ],
        ],
    ],
];
