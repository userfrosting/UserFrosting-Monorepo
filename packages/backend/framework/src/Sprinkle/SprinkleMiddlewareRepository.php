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

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Repository of all MiddlewareInterface declared for all registered sprinkles.
 *
 * @extends ClassRepository<MiddlewareInterface>
 */
class SprinkleMiddlewareRepository extends ClassRepository
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
            if (!$sprinkle instanceof MiddlewareRecipe) {
                continue;
            }
            foreach ($sprinkle->getMiddlewares() as $commandsClass) {
                if (!class_exists($commandsClass)) {
                    throw new BadClassNameException("Middleware class `$commandsClass` not found.");
                }
                $instance = $this->ci->get($commandsClass);
                if (!is_object($instance) || !is_subclass_of($instance, MiddlewareInterface::class)) {
                    throw new BadInstanceOfException("Middleware class `$commandsClass` doesn't implement " . MiddlewareInterface::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
