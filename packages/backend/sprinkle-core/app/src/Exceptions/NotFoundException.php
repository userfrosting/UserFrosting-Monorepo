<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Exceptions;

use Exception;
use UserFrosting\Support\Message\UserMessage;

/**
 * Base exception for when _something_ is not found. Default to a typical 404
 * Not Found message, but should be extended to provide more specific messages.
 */
class NotFoundException extends UserFacingException
{
    protected string $title = 'ERROR.404.TITLE';
    protected string|UserMessage $description = 'ERROR.404.DESCRIPTION';
    protected int $httpCode = 404;
}
