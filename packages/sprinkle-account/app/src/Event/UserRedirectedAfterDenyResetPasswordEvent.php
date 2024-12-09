<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use UserFrosting\Sprinkle\Core\Event\Contract\RedirectingEventInterface;
use UserFrosting\Sprinkle\Core\Event\Helper\RedirectTrait;
use UserFrosting\Sprinkle\Core\Event\Helper\StoppableTrait;

class UserRedirectedAfterDenyResetPasswordEvent implements StoppableEventInterface, RedirectingEventInterface
{
    use StoppableTrait;
    use RedirectTrait;
}
