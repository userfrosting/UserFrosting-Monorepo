<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Exceptions;

use UserFrosting\Support\Message\UserMessage;

/**
 * Disabled account exception. Used when an account has been disabled.
 */
final class AccountDisabledException extends AccountException
{
    protected string $title = 'ACCOUNT.EXCEPTION.DISABLED.TITLE';
    protected string|UserMessage $description = 'ACCOUNT.EXCEPTION.DISABLED.DESCRIPTION';
}
