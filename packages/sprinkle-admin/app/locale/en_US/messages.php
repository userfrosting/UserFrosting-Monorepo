<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

/**
 * US English message token translations for the 'admin' sprinkle.
 *
 * @author Alexander Weissman
 */
return [
    'ACTIVITY' => [
        1 => 'Activity', //OK
        2 => 'Activities', //OK

        'LAST'             => 'Last Activity', //OK
        'LATEST'           => 'Latest Activities', //OK
        'PAGE'             => 'Activities', //OK
        'PAGE_DESCRIPTION' => 'A listing of user activities', //OK
        'TIME'             => 'Activity Time', //OK
    ],
    'ADMIN_PANEL' => 'Admin Panel', //OK

    'CACHE' => [
        'CLEAR'             => 'Clear cache',
        'CLEAR_CONFIRM'     => 'Are you sure you want to clear the site cache?',
        'CLEAR_CONFIRM_YES' => 'Yes, clear cache',
        'CLEARED'           => 'Cache cleared successfully !',
    ],

    'DASHBOARD'             => 'Dashboard',
    'DELETE_MASTER'         => 'You cannot delete the master account',
    'DELETION_SUCCESSFUL'   => 'User <strong>{{user_name}}</strong> has been successfully deleted.',
    'DETAILS_UPDATED'       => 'Account details updated for user <strong>{{user_name}}</strong>',
    'DISABLE_MASTER'        => 'You cannot disable the master account',
    'DISABLE_SELF'          => 'You cannot disable your own account',
    'DISABLE_SUCCESSFUL'    => 'Account for user <strong>{{user_name}}</strong> has been successfully disabled.',

    'ENABLE_SUCCESSFUL' => 'Account for user <strong>{{user_name}}</strong> has been successfully enabled.',

    'GROUP' => [
        1 => 'Group',
        2 => 'Groups',

        'CREATE'              => 'Create group',//OK
        'CREATION_SUCCESSFUL' => 'Successfully created group <strong>{{name}}</strong>',
        'DELETE'              => 'Delete group',//OK
        'DELETE_CONFIRM'      => 'Are you sure you want to delete the group <strong>{{name}}</strong>?',//OK
        'DELETE_DEFAULT'      => "You can't delete the group <strong>{{name}}</strong> because it is the default group for newly registered users.",
        'DELETE_YES'          => 'Yes, delete group',//OK
        'DELETION_SUCCESSFUL' => 'Successfully deleted group <strong>{{name}}</strong>',
        'EDIT'                => 'Edit group',//OK
        'EXCEPTION'           => 'Group error',
        'ICON'                => 'Group icon',//OK
        'ICON_EXPLAIN'        => 'Icon for group members',//OK
        'INFO_PAGE'           => 'View and edit group details.', //OK
        'MANAGE'              => 'Manage group',
        'NAME'                => 'Group name',//OK
        'NAME_IN_USE'         => 'A group named <strong>{{name}}</strong> already exist',
        'NAME_EXPLAIN'        => 'Please enter a name for the group',//OK
        'NONE'                => 'No group',
        'NOT_EMPTY'           => "You can't do that because there are still users associated with the group <strong>{{name}}</strong>.",
        'NOT_FOUND'           => 'Group not found',
        'PAGE'                => 'Groups', //OK
        'PAGE_DESCRIPTION'    => 'A listing of the groups for your site.  Provides management tools for editing and deleting groups.', //OK
        'UPDATE'              => 'Details updated for group <strong>{{name}}</strong>',
        'USERS'               => 'Users in this group',
    ],

    'MANUALLY_ACTIVATED'    => "{{user_name}}'s account has been manually activated",
    'MASTER_ACCOUNT_EXISTS' => 'The master account already exists!',
    'MIGRATION'             => [
        'REQUIRED'          => 'Database update required',
    ],

    'NO_FEATURES_YET'       => "It doesn't look like any features have been set up for this account...yet.  Maybe they haven't been implemented yet, or maybe someone forgot to give you access.  Either way, we're glad to have you aboard!",

    'PERMISSION' => [
        1 => 'Permission',//OK
        2 => 'Permissions',//OK

        'ASSIGN'            => [
            '@TRANSLATION' => 'Assign permissions',//OK
            'EXPLAIN'      => 'The selected permissions will be assigned to the role.',//OK
        ],
        'HOOK_CONDITION'    => 'Hook/Conditions',//OK
        'ID'                => 'Permission ID',//OK
        'INFO_PAGE'         => 'View and edit permission details.', //OK
        'MANAGE'            => 'Manage permissions',
        'NOT_FOUND'         => 'Permission not found',
        'PAGE'              => 'Permissions', //OK
        'PAGE_DESCRIPTION'  => 'A listing of the permissions for your site.  Provides management tools for editing and deleting permissions.', //OK
        'UPDATE'            => 'Update permissions',//OK
        'USERS'             => 'Users with this permission',//OK
        'VIA_ROLES'         => 'Has permission via roles',
    ],

    'ROLE' => [
        1 => 'Role',//OK
        2 => 'Roles',//OK

        'CREATE'              => 'Create role',//OK
        'CREATION_SUCCESSFUL' => 'Successfully created role <strong>{{name}}</strong>',
        'DELETE'              => 'Delete role',//OK
        'DELETE_CONFIRM'      => 'Are you sure you want to delete the role <strong>{{name}}</strong>?',//OK
        'DELETE_DEFAULT'      => "You can't delete the role <strong>{{name}}</strong> because it is a default role for newly registered users.",
        'DELETE_YES'          => 'Yes, delete role',//OK
        'DELETION_SUCCESSFUL' => 'Successfully deleted role <strong>{{name}}</strong>',
        'EDIT'                => 'Edit role',//OK
        'EXCEPTION'           => 'Role error',
        'HAS_USERS'           => "You can't do that because there are still users who have the role <strong>{{name}}</strong>.",
        'INFO_PAGE'           => 'View and edit role details.', //OK
        'MANAGE'              => 'Manage Roles', //OK
        'MANAGE_EXPLAIN'      => 'The selected roles will be assigned to the user.', //OK
        'NAME'                => 'Name',//OK
        'NAME_EXPLAIN'        => 'Please enter a name for the role',//OK
        'NAME_IN_USE'         => 'A role named <strong>{{name}}</strong> already exist',
        'NOT_FOUND'           => 'Role not found',
        'PAGE'                => 'Roles', //OK
        'PAGE_DESCRIPTION'    => 'A listing of the roles for your site. Provides management tools for editing and deleting roles.', //OK
        'PERMISSIONS'         => 'Role permissions',
        'PERMISSIONS_UPDATED' => 'Permissions updated for role <strong>{{name}}</strong>',
        'UPDATE'              => 'Update Roles', //OK
        'UPDATED'             => 'Details updated for role <strong>{{name}}</strong>',
        'USERS'               => 'Users with this role',
    ],

    'SYSTEM_INFO' => [
        '@TRANSLATION'  => 'System information', //OK
        'DB_NAME'       => 'Database Name', //OK
        'DB_CONNECTION' => 'Database Connection', //OK
        'DB_VERSION'    => 'Database Version', //OK
        'DIRECTORY'     => 'Project Directory', //OK
        'PHP_VERSION'   => 'PHP Version', //OK
        'SERVER'        => 'Webserver Software', //OK
        'SPRINKLES'     => 'Loaded Sprinkles', //OK
        'UF_VERSION'    => 'Framework Version', //OK
    ],

    'TOGGLE_COLUMNS' => 'Toggle columns',

    'USER' => [
        1 => 'User', //OK
        2 => 'Users', //OK

        'ADMIN' => [
            'CHANGE_PASSWORD'    => 'Change User Password',
            'SEND_PASSWORD_LINK' => 'Send the user a link that will allow them to choose their own password',
            'SET_PASSWORD'       => "Set the user's password as",
            'PASSWORD_RESET'     => 'A password reset link will be sent to <strong>{{email}}</strong>.',
        ],
        'ACTIVATE'          => 'Activate user', //OK
        'ACTIVATE_CONFIRM'  => 'Are you sure you want to activate <strong>{{full_name}} ({{user_name}})</strong> ?', //OK
        'CREATE'            => 'Create user', //OK
        'CREATED'           => 'User <strong>{{user_name}}</strong> has been successfully created',
        'DELETE'            => 'Delete user', //OK
        'DELETE_CONFIRM'    => 'Are you sure you want to delete the user <strong>{{full_name}} ({{user_name}})</strong>?', //OK
        'DELETED'           => 'User deleted', //OK
        'DISABLE'           => 'Disable user', //OK
        'DISABLE_CONFIRM'   => 'Are you sure you want to disable <strong>{{full_name}} ({{user_name}})</strong> ?', //OK
        'EDIT'              => 'Edit user',
        'ENABLE'            => 'Enable user', //OK
        'ENABLE_CONFIRM'    => 'Are you sure you want to enable <strong>{{full_name}} ({{user_name}})</strong> ?', //OK
        'INFO_PAGE'         => 'View and edit user details.', //OK
        'LATEST'            => 'Latest Users', //OK
        'PAGE'              => 'Users', //OK
        'PAGE_DESCRIPTION'  => 'A listing of the users for your site. Provides management tools including the ability to edit user details, manually activate users, enable/disable users, and more.', //OK
        'VIEW_ALL'          => 'View all users', //OK
    ],

    'X_USER' => [
        0 => 'No users',
        1 => '{{plural}} user',
        2 => '{{plural}} users',
    ],
];
