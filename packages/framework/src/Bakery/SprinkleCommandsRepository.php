<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Bakery;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use UserFrosting\Sprinkle\BakeryRecipe;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Repository of all Bakery Command declared for all registered sprinkles.
 *
 * @extends ClassRepository<Command>
 */
class SprinkleCommandsRepository extends ClassRepository
{
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
            if (!$sprinkle instanceof BakeryRecipe) {
                continue;
            }
            foreach ($sprinkle->getBakeryCommands() as $commandsClass) {
                if (!class_exists($commandsClass)) {
                    throw new BadClassNameException("Bakery command class `$commandsClass` not found.");
                }
                $instance = $this->ci->get($commandsClass);
                if (!is_object($instance) || !is_subclass_of($instance, Command::class)) {
                    throw new BadInstanceOfException("Bakery command class `$commandsClass` doesn't implement " . Command::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
