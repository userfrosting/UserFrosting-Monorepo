<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

/**
 * US English message token translations for the 'core' sprinkle.
 */

return [
    'ERROR' => [
        '@TRANSLATION' => 'Error',

        '400' => [
            'TITLE'       => 'Bad Request',
            'DESCRIPTION' => 'The server cannot or will not process the request due to an apparent client error.',
        ],
        '401' => [
            'TITLE'       => 'Unauthorized',
            'DESCRIPTION' => 'The request requires valid user authentication.',
        ],
        '403' => [
            'TITLE'       => 'Forbidden',
            'DESCRIPTION' => 'You are not permitted to perform the requested operation.',
        ],
        '404' => [
            'TITLE'       => 'Not Found',
            'DESCRIPTION' => 'The requested resource could not be found.',
        ],
        '405' => [
            'TITLE'       => 'Method Not Allowed',
            'DESCRIPTION' => 'The request method is not supported for the requested resource.',
        ],
        '410' => [
            'TITLE'       => 'Gone',
            'DESCRIPTION' => 'The target resource is no longer available at the origin server.',
        ],

        // Generic title and description for error code not handled above
        'TITLE'       => "We've sensed a great disturbance in the Force.",
        'DESCRIPTION' => "Oops, looks like our server might have goofed. If you're an admin, please check the PHP or UserFrosting logs.",

        'MAIL' => 'Fatal error attempting mail, contact your server administrator.  If you are the admin, please check the UserFrosting log.',

        'RATE_LIMIT_EXCEEDED' => [
            'TITLE'       => 'Rate Limit Exceeded',
            'DESCRIPTION' => 'The rate limit for this action has been exceeded. You must wait another {{delay}} seconds before you will be allowed to make another attempt.',
        ],
    ],
];
