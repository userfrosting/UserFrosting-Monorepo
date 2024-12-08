<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Migrator;

use Psr\Container\ContainerInterface;
use UserFrosting\Sprinkle\Core\Database\MigrationInterface;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\MigrationRecipe;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Find and returns all migrations definitions (classes) registered and available.
 *
 * @extends ClassRepository<MigrationInterface>
 */
final class SprinkleMigrationLocator extends ClassRepository implements MigrationLocatorInterface
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
            if (!$sprinkle instanceof MigrationRecipe) {
                continue;
            }
            foreach ($sprinkle->getMigrations() as $commandsClass) {
                if (!class_exists($commandsClass)) {
                    throw new BadClassNameException("Migration class `$commandsClass` not found.");
                }
                $instance = $this->ci->get($commandsClass);
                if (!is_object($instance) || !is_subclass_of($instance, MigrationInterface::class)) {
                    throw new BadInstanceOfException("Migration class `$commandsClass` doesn't implement " . MigrationInterface::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
