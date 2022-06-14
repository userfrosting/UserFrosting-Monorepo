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

use UserFrosting\Sprinkle\Account\Exceptions\AccountException;
use UserFrosting\Support\Message\UserMessage;

/**
 * Role related exceptions. The description is expected to be set by the controller.
 */
final class RoleException extends AccountException
{
    protected string $title = 'ROLE.EXCEPTION';
    protected string|UserMessage $description = 'ROLE.EXCEPTION';
}
