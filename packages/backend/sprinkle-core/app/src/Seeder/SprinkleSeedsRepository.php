<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Seeder;

use Psr\Container\ContainerInterface;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\SeedRecipe;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Find and returns all registered SeedInterface across all sprinkles, using SeedRecipe.
 *
 * @extends ClassRepository<SeedInterface>
 */
final class SprinkleSeedsRepository extends ClassRepository implements SeedRepositoryInterface
{
    /**
     * @param SprinkleManager    $sprinkleManager
     * @param ContainerInterface $ci
     */
    public function __construct(
        protected SprinkleManager $sprinkleManager,
        protected ContainerInterface $ci
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        $instances = [];

        foreach ($this->sprinkleManager->getSprinkles() as $sprinkle) {
            if (!$sprinkle instanceof SeedRecipe) {
                continue;
            }
            foreach ($sprinkle->getSeeds() as $commandsClass) {
                if (!class_exists($commandsClass)) {
                    throw new BadClassNameException("Seed class `$commandsClass` not found.");
                }
                $instance = $this->ci->get($commandsClass);
                if (!is_object($instance) || !is_subclass_of($instance, SeedInterface::class)) {
                    throw new BadInstanceOfException("Seed class `$commandsClass` doesn't implement " . SeedInterface::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
