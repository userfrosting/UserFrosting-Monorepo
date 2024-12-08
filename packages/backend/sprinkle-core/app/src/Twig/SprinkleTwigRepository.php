<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Twig;

use Psr\Container\ContainerInterface;
use Twig\Extension\ExtensionInterface;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\TwigExtensionRecipe;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Find and returns all registered ExtensionInterface across all sprinkles, using TwigExtensionRecipe.
 *
 * @extends ClassRepository<ExtensionInterface>
 */
final class SprinkleTwigRepository extends ClassRepository implements TwigRepositoryInterface
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
            if (!$sprinkle instanceof TwigExtensionRecipe) {
                continue;
            }
            foreach ($sprinkle->getTwigExtensions() as $commandsClass) {
                if (!class_exists($commandsClass)) {
                    throw new BadClassNameException("Extension class `$commandsClass` not found.");
                }
                $instance = $this->ci->get($commandsClass);
                if (!is_object($instance) || !is_subclass_of($instance, ExtensionInterface::class)) {
                    throw new BadInstanceOfException("Extension class `$commandsClass` doesn't implement " . ExtensionInterface::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
