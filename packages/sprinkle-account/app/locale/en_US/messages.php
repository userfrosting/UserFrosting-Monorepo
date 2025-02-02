<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

/**
 * US English message token translations for the 'account' sprinkle.
 *
 * @author Alexander Weissman
 */
return [
    'ACCOUNT' => [
        '@TRANSLATION' => 'Account',

        'EXCEPTION' => [
            'TITLE'       => 'Account Exception',
            'DESCRIPTION' => 'An unspecified error with he account has been encountered.',

            'ACCESS_DENIED' => [
                'TITLE'       => 'Access Denied',
                'DESCRIPTION' => "Hmm, looks like you don't have permission to do that.",
            ],
            'DISABLED' => [
                'TITLE'       => 'Account Disabled',
                'DESCRIPTION' => 'This account has been disabled. Please contact us for more information.',
            ],
            'DEFAULT_GROUP' => [
                'TITLE'       => 'Default Group Not Found',
                'DESCRIPTION' => 'Account registration is not working because the default group {{slug}} does not exist.',
            ],
            'INVALID' => [
                'TITLE'       => 'Account Invalid',
                'DESCRIPTION' => 'This account is not configured properly. Please contact us for more information.',
            ],
            'NOT_FOUND' => [
                'TITLE'       => 'Account Not Found',
                'DESCRIPTION' => 'This account does not exist. It may have been deleted.',
            ],
            'COMPROMISED' => [
                'TITLE'       => 'Account Compromised',
                'DESCRIPTION' => 'Someone may have used your login information to access this page.  For your safety, all sessions were logged out. Please log in again and check your account for suspicious activity. You may also wish to change your password.',
            ],
            'UNVERIFIED' => [
                'TITLE'       => 'Account Unverified',
                'DESCRIPTION' => 'Your account has not yet been verified. Check your emails / spam folder for account activation instructions.',
            ],
            'EXPIRED' => [
                'TITLE'       => 'Session expired',
                'DESCRIPTION' => 'Your session has expired.  Please sign in again.',
            ],
            'INVALID_CREDENTIALS' => [
                'TITLE'       => 'Invalid Credentials',
                'DESCRIPTION' => 'User not found or password is invalid.',
            ],
            'LOGGEDIN' => [
                'TITLE'       => 'Already Logged-in',
                'DESCRIPTION' => "Can't access this resource, as you're already logged-in",
            ],
            'LOGIN_REQUIRED' => [
                'TITLE'       => 'Login Required',
                'DESCRIPTION' => 'Please login to continue',
            ],
            'PASSWORD_RESET' => [
                'TITLE'       => 'Invalid Password Reset Token',
                'DESCRIPTION' => 'This password reset request could not be found, or has expired.',
            ],
        ],

        'EMAIL_UPDATED' => 'Account email updated',
        'ERROR'         => [
            '@TRANSLATION'  => 'Error validating account',
            'MISSING_PARAM' => "Account can't be registered as '{{param}}' is required.",
        ],

        'MASTER_NOT_EXISTS' => 'You cannot register an account until the master account has been created!',
        'MY'                => 'My Account',

        'SETTINGS' => [
            '@TRANSLATION'  => 'Account settings',
            'DESCRIPTION'   => 'Update your account settings, including email, name, and password.',
            'UPDATED'       => 'Account settings updated',
        ],

        'TOOLS' => 'Account tools',

        'VERIFICATION' => [
            'NEW_LINK_SENT'     => 'We have emailed a new verification link to {{email}}.  Please check your inbox and spam folders for this email.',
            'RESEND'            => 'Resend verification email',
            'COMPLETE'          => 'You have successfully verified your account. You can now login.',
            'EMAIL'             => 'Please enter the email address you used to sign up, and your verification email will be resent.',
            'PAGE'              => 'Resend the verification email for your new account.',
            'SEND'              => 'Email the verification link for my account',
            'TOKEN_NOT_FOUND'   => 'Verification token does not exist / Account is already verified',
        ],
    ],

    'EMAIL' => [
        'INVALID'               => 'Invalid email',
        'IN_USE'                => 'Email <strong>{{email}}</strong> is already in use.',
        'NOT_FOUND'             => 'There is no account for <strong>{{email}}</strong>.',
        'VERIFICATION_REQUIRED' => 'Email (verification required - use a real address!)',
    ],

    'EMAIL_OR_USERNAME' => 'Username or email address',

    'FIRST_NAME' => 'First name',

    'GUEST' => 'Guest',

    'HEADER_MESSAGE_ROOT' => 'YOU ARE SIGNED IN AS THE ROOT USER',

    'LAST_NAME' => 'Last name',
    'LOCALE'    => [
        'ACCOUNT' => 'The language and locale to use for your account',
        'INVALID' => '{{locale}} is not a valid locale.',
    ],
    'LOGIN' => [
        '@TRANSLATION'      => 'Login',
        'ALREADY_COMPLETE'  => 'You are already logged in!',
        'SOCIAL'            => 'Or login with',
        'REQUIRED'          => 'Sorry, you must be logged in to access this resource.',
    ],
    'LOGOUT' => 'Logout',

    'NAME' => 'Name',

    'NAME_AND_EMAIL' => 'Name and email',

    'PAGE' => [
        'LOGIN' => [
            'DESCRIPTION'   => 'Sign in to your {{site_name}} account, or register for a new account.',
            'SUBTITLE'      => 'Register for free, or sign in with an existing account.',
            'TITLE'         => "Let's get started!",
        ],
    ],

    'PASSWORD' => [
        '@TRANSLATION' => 'Password',

        'BETWEEN'   => 'Between {{min}}-{{max}} characters',

        'CONFIRM'               => 'Confirm password',
        'CONFIRM_CURRENT'       => 'Please confirm your current password',
        'CONFIRM_NEW'           => 'Confirm New Password',
        'CONFIRM_NEW_EXPLAIN'   => 'Re-enter your new password',
        'CONFIRM_NEW_HELP'      => 'Required only if selecting a new password',
        'CREATE'                => [
            '@TRANSLATION'  => 'Create Password',
            'PAGE'          => 'Choose a password for your new account.',
            'SET'           => 'Set Password and Sign In',
        ],
        'CURRENT'               => 'Current Password',
        'CURRENT_EXPLAIN'       => 'You must confirm your current password to make changes',

        'FORGOTTEN' => 'Forgotten Password',
        'FORGET'    => [
            '@TRANSLATION' => 'I forgot my password',

            'COULD_NOT_UPDATE'  => "Couldn't update password.",
            'EMAIL'             => 'Please enter the email address you used to sign up. A link with instructions to reset your password will be emailed to you.',
            'EMAIL_SEND'        => 'Email Password Reset Link',
            'PAGE'              => 'Get a link to reset your password.',
            'REQUEST_CANNED'    => 'Lost password request cancelled.',
            'REQUEST_SENT'      => 'If the email <strong>{{email}}</strong> matches an account in our system, a password reset link will be sent to <strong>{{email}}</strong>.',
        ],

        'HASH_FAILED'       => 'Password hashing failed. Please contact a site administrator.',
        'INVALID'           => "Current password doesn't match the one we have on record",
        'NEW'               => 'New Password',
        'NOTHING_TO_UPDATE' => 'You cannot update with the same password',

        'RESET' => [
            '@TRANSLATION'      => 'Reset Password',
            'CHOOSE'            => 'Please choose a new password to continue.',
            'PAGE'              => 'Choose a new password for your account.',
            'SEND'              => 'Set New Password and Sign In',
        ],

        'UPDATED'           => 'Account password updated',
    ],

    'PROFILE'       => [
        'SETTINGS'  => 'Profile settings',
        'UPDATED'   => 'Profile settings updated',
    ],

    'RATE_LIMIT_EXCEEDED'       => 'The rate limit for this action has been exceeded.  You must wait another {{delay}} seconds before you will be allowed to make another attempt.',

    'REGISTER'      => 'Register',
    'REGISTER_ME'   => 'Sign me up',
    'REGISTRATION'  => [
        'ERROR'             => 'Registration error',
        'UNKNOWN'           => 'A problem was encountered during the account registration process.',
        'COMPLETE_TYPE1'    => 'You have successfully registered. You can now sign in.',
        'COMPLETE_TYPE2'    => 'You have successfully registered. A link to activate your account has been sent to <strong>{{email}}</strong>.  You will not be able to sign in until you complete this step.',
        'DISABLED'          => "We're sorry, account registration has been disabled.",
        'LOGOUT'            => "I'm sorry, you cannot register for an account while logged in. Please log out first.",
        'WELCOME'           => 'Registration is fast and simple.',
    ],
    'REMEMBER_ME'               => 'Keep me signed in',
    'REMEMBER_ME_ON_COMPUTER'   => 'Remember me on this computer (not recommended for public computers)',

    'SIGN_IN_HERE'          => 'Already have an account? <a href="{{url}}">Sign in here.</a>',
    'SIGNIN'                => 'Sign in',
    'SIGNIN_OR_REGISTER'    => 'Sign in or register',
    'SIGNUP'                => 'Sign Up',

    'TOS'           => 'Terms and Conditions',
    'TOS_AGREEMENT' => 'By registering an account with {{site_title}}, you accept the <a {{link_attributes | raw}}>terms and conditions</a>.',
    'TOS_FOR'       => 'Terms and Conditions for {{title}}',

    'USERNAME' => [
        '@TRANSLATION' => 'Username',

        'CHOOSE'        => 'Choose a unique username',
        'INVALID'       => 'Invalid username',
        'IN_USE'        => 'Username <strong>{{user_name}}</strong> is already in use.',
        'NOT_AVAILABLE' => "Username <strong>{{user_name}}</strong> is not available. Choose a different name, or click 'suggest'.",
    ],

    'WELCOME' => 'Welcome back, {{full_name}}!',
];
