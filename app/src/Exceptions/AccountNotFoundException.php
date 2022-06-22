<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Exceptions;

use Exception;

/**
 * Group not found exception.
 */
final class AccountNotFoundException extends NotFoundException
{
    protected string $title = 'ACCOUNT.EXCEPTION.NOT_FOUND.TITLE';
    protected string $description = 'ACCOUNT.EXCEPTION.NOT_FOUND.DESCRIPTION';
}
