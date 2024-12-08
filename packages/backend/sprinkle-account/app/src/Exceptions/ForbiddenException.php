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
 * Forbidden Exception. Used when an account doesn't have access to a resource.
 */
final class ForbiddenException extends AccountException
{
    protected string $title = 'ACCOUNT.EXCEPTION.ACCESS_DENIED.TITLE';
    protected string|UserMessage $description = 'ACCOUNT.EXCEPTION.ACCESS_DENIED.DESCRIPTION';
    protected int $httpCode = 403;
}
