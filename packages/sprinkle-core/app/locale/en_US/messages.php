<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

/**
 * US English message token translations for the 'core' sprinkle.
 *
 * @author Alexander Weissman
 */
return [
    'BUILT_WITH_UF' => 'Created with <a href="http://www.userfrosting.com">UserFrosting</a>', //OK

    'CAPTCHA' => [
        '@TRANSLATION' => 'Captcha',
        'FAIL'         => 'You did not enter the captcha code correctly.',
        'SPECIFY'      => 'Enter the captcha', //OK
        'VERIFY'       => 'Verify the captcha', //OK
    ],
    'COPYRIGHT'     => 'Copyright {{year}}', //OK

    'CSRF_MISSING' => 'Missing CSRF token. Try refreshing the page and then submitting again?',

    'DB_INVALID'    => 'Cannot connect to the database.  If you are an administrator, please check your error log.',
    'DESCRIPTION'   => 'Description',
    'DOWNLOAD'      => [
        '@TRANSLATION' => 'Download',
        'CSV'          => 'Download CSV',
    ],

    'EMAIL' => [
        '@TRANSLATION' => 'Email', //OK
        'YOUR'         => 'Your email address', //OK
    ],

    'HOME'  => 'Home',

    'LEGAL' => [
        '@TRANSLATION' => 'Legal Policy',
        'DESCRIPTION'  => 'Our legal policy applies to your usage of this website and our services.',
    ],

    'LOCALE' => [
        '@TRANSLATION' => 'Locale', //OK
    ],

    'NAME'       => 'Name',
    'NAVIGATION' => 'Navigation',
    'NO_RESULTS' => "Sorry, we've got nothing here.",

    'PAGINATION' => [
        // 'GOTO' => 'Jump to Page',
        // 'SHOW' => 'Show',
        'OUTPUT'   => 'Showing {{first}} - {{last}} of {{count}}',//OK
        // 'NEXT'     => 'Next page',
        'PAGE_X_OF_Y' => 'Page {{current}} of {{last}}', //OK
        'PER_PAGE' => '{{count}} per page', //OK
        // 'PREVIOUS' => 'Previous page',
        // 'FIRST'    => 'First page',
        // 'LAST'     => 'Last page',
    ],
    'PRIVACY' => [
        '@TRANSLATION' => 'Privacy Policy',
        'DESCRIPTION'  => 'Our privacy policy outlines what kind of information we collect from you and how we will use it.',
    ],

    'SLUG'           => 'Slug',
    'SLUG_CONDITION' => 'Slug/Conditions',
    'SLUG_IN_USE'    => 'A <strong>{{slug}}</strong> slug already exists',
    'SPRUNJE'        => [
        'FILTERS'      => 'Filters',//OK
        'FILTER_CLEAR' => 'Clear filters',//OK
        'SEARCH'       => 'Search {{term}}...',//OK
    ],
    'STATUS'         => 'Status',
    'SUGGEST'        => 'Suggest',

    'THEME_BY'      => 'Theme built with', //OK

    'UNKNOWN' => 'Unknown',

    // Actions words
    'ACTIONS'                  => 'Actions',
    'ACTIVATE'                 => 'Activate',
    'ACTIVE'                   => 'Active',
    'ADD'                      => 'Add',
    'CANCEL'                   => 'Cancel', //OK
    'CONFIRM'                  => 'Confirm', //OK
    'CONFIRM_ACTION'           => 'Please confirm to proceed.', //OK
    'CONFIRMATION'             => 'Confirmation', //OK
    'CREATE'                   => 'Create',
    'CREATED_ON'               => 'Created on', //OK
    'DELETE'                   => 'Delete',
    'DELETE_CONFIRM'           => 'Are you sure you want to delete this?',
    'DELETE_CONFIRM_YES'       => 'Yes, delete',
    'DELETE_CONFIRM_NAMED'     => 'Are you sure you want to delete {{user_name}}?',
    'DELETE_CONFIRM_YES_NAMED' => 'Yes, delete {{name}}',
    'DELETE_CANNOT_UNDONE'     => 'This action cannot be undone.',
    'DELETE_NAMED'             => 'Delete {{name}}',
    'DENY'                     => 'Deny',
    'DISABLE'                  => 'Disable',
    'DISABLED'                 => 'Disabled',
    'EDIT'                     => 'Edit',
    'ENABLE'                   => 'Enable',
    'ENABLED'                  => 'Enabled',
    'NO'                       => 'No',
    'NONE'                     => 'None',
    'OPTIONAL'                 => 'Optional',
    'OVERRIDE'                 => 'Override',
    'RESET'                    => 'Reset',
    'SAVE'                     => 'Save',
    'SEARCH'                   => 'Search',
    'SORT'                     => 'Sort',
    'SUBMIT'                   => 'Submit',
    'PRINT'                    => 'Print',
    'REMOVE'                   => 'Remove',
    'UNACTIVATED'              => 'Unactivated',
    'UPDATE'                   => 'Update',
    'VIEW'                     => 'View',
    'YES'                      => 'Yes',
];
