<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration;

use UserFrosting\Sprinkle\SprinkleRecipe;

class TestSprinkle implements SprinkleRecipe
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Test Sprinkle';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSprinkles(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getServices(): array
    {
        return [];
    }
}
