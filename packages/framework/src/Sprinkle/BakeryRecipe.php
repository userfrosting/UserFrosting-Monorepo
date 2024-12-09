<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle;

/**
 * Sprinkle Bakery definition Interface.
 */
interface BakeryRecipe
{
    /**
     * Return an array of all registered Bakery Commands.
     *
     * @return class-string<\Symfony\Component\Console\Command\Command>[]
     */
    public function getBakeryCommands(): array;
}
