<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Exceptions;

use UserFrosting\Support\Message\UserMessage;

/**
 * Invalid account exception. Used when an account has been removed during an active session.
 */
final class AccountNotFoundException extends AccountException
{
    protected string $title = 'ACCOUNT.EXCEPTION.NOT_FOUND.TITLE';
    protected string|UserMessage $description = 'ACCOUNT.EXCEPTION.NOT_FOUND.DESCRIPTION';
}
