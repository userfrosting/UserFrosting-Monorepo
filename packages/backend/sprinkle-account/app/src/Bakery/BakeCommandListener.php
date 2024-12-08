<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Bakery;

use UserFrosting\Sprinkle\Core\Bakery\Event\BakeCommandEvent;

/**
 * Adding Account provided `create-admin` to the bake command.
 */
class BakeCommandListener
{
    public function __invoke(BakeCommandEvent $event): void
    {
        $event->addCommand('create:admin-user');
    }
}
