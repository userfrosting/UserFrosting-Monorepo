<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Exceptions\Contracts;

use UserFrosting\Support\Message\UserMessage;

interface UserMessageException
{
    /**
     * Return user facing message title.
     *
     * @return string|UserMessage
     */
    public function getTitle(): string|UserMessage;

    /**
     * Return user facing message description.
     *
     * @return string|UserMessage
     */
    public function getDescription(): string|UserMessage;
}
