<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Routes;

use Psr\Container\ContainerInterface;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Repository of all RouteDefinitionInterface declared for all registered sprinkles.
 *
 * @extends ClassRepository<RouteDefinitionInterface>
 */
class SprinkleRoutesRepository extends ClassRepository
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
            foreach ($sprinkle->getRoutes() as $routesClass) {
                if (!class_exists($routesClass)) {
                    throw new BadClassNameException("Routes definition class `$routesClass` not found.");
                }
                $instance = $this->ci->get($routesClass);
                if (!is_object($instance) || !is_subclass_of($instance, RouteDefinitionInterface::class)) {
                    throw new BadInstanceOfException("Routes definition class `$routesClass` doesn't implement " . RouteDefinitionInterface::class . '.');
                }
                $instances[] = $instance;
            }
        }

        return $instances;
    }
}
