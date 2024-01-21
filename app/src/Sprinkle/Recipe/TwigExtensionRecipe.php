<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Sprinkle\Recipe;

/**
 * Sprinkle Twig Extensions definition Interface.
 */
interface TwigExtensionRecipe
{
    /**
     * Return an array of all registered Twig Extensions.
     *
     * @return class-string<\Twig\Extension\ExtensionInterface>[]
     */
    public function getTwigExtensions(): array;
}
