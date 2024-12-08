<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Log;

enum UserActivityTypes: string
{
    case REGISTER = 'sign_up';
    case VERIFIED = 'verified';
    case PASSWORD_RESET = 'password_reset';
    case LOGGED_IN = 'sign_in';
    case LOGGED_OUT = 'sign_out';
    case PASSWORD_UPGRADED = 'password_upgraded';
}
