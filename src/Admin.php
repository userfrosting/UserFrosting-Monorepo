<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin;

use UserFrosting\Sprinkle\SprinkleReceipe;

class Admin implements SprinkleReceipe
{
    /**
     * {@inheritdoc}
     */
    public static function getName(): string
    {
        return 'Admin Sprinkle';
    }

    /**
     * {@inheritdoc}
     */
    public static function getPath(): string
    {
        return __DIR__;
    }

    /**
     * {@inheritdoc}
     */
    public static function getBakeryCommands(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getSprinkles(): array
    {
        return [];
    }
}
