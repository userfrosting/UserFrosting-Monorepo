<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Error\Handler;

use Throwable;
use UserFrosting\Sprinkle\Core\Util\Message\Message;

/**
 * Handler for phpMailer exceptions.
 */
final class PhpMailerExceptionHandler extends ExceptionHandler
{
    /**
     * {@inheritDoc}
     */
    protected function determineUserMessage(Throwable $exception, int $statusCode): Message
    {
        return new Message(
            $this->translateUserMessage('ERROR.MAIL')
        );
    }
}
