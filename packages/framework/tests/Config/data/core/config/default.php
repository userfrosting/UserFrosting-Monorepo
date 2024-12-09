<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

/*
 * Default configuration file for your project, which can be overridden by environment-specific configuration files.
 */
return [
    'site' => [
        'AdminLTE' => [
            'skin' => 'blue',
        ],
        'analytics' => [
            'google' => [
                'code'    => '',
                'enabled' => false,
            ],
        ],
        'author'    => 'Author',
        'csrf'      => null,
        'debug'     => [
            'ajax' => false,
            'info' => true,
        ],
        'locales' => [
            'available' => [
                'en_US' => 'English',
                'ar'    => 'العربية',
                'fr_FR' => 'Français',
                'pt_PT' => 'Português',
                'de_DE' => 'Deutsch',
                'th_TH' => 'ภาษาไทย',
            ],
            // This can be a comma-separated list, to load multiple fallback locales
            'default' => 'en_US',
        ],
        'title'     => 'UserFrosting',
        // URLs
        'uri' => [
            'base' => [
                'host'              => 'localhost',
                'scheme'            => 'http',
                'port'              => null,
                'path'              => 'myProject',
            ],
            'author'            => 'http://www.userfrosting.com',
            'publisher'         => '',
        ],
    ],
    'timezone' => 'America/New_York',
];
