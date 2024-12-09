<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting;

use DI\Container;
use DI\ContainerBuilder;
use UserFrosting\ServicesProvider\FrameworkService;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\Sprinkle\SprinkleRecipe;

/**
 * Base class for UserFrosting application.
 */
abstract class Cupcake
{
    /**
     * @var Container The global container object, which holds all your services.
     */
    protected Container $ci;

    /**
     * @var SprinkleManager
     */
    protected SprinkleManager $sprinkleManager;

    /**
     * Constructor.
     *
     * @param class-string<SprinkleRecipe>|SprinkleRecipe $mainSprinkle
     */
    public function __construct(protected string|SprinkleRecipe $mainSprinkle)
    {
        $this->init();
    }

    /**
     * Initialize the application. Setup Sprinkles, DI Container and the base app.
     */
    public function init(): void
    {
        // Setup sprinkles
        $this->sprinkleManager = new SprinkleManager($this->mainSprinkle);

        // Create the DI container
        $this->ci = $this->createContainer();

        // Register SprinkleManager into the CI
        $this->ci->set(SprinkleManager::class, $this->sprinkleManager);

        // Create application
        $this->initiateApp();
    }

    /**
     * Run application.
     */
    abstract public function run(): void;

    /**
     * Return the underlying Slim or Symfony Application instance, if available.
     *
     * @return mixed
     */
    abstract public function getApp();

    /**
     * Return the DI container.
     *
     * @return Container
     */
    public function getContainer(): Container
    {
        return $this->ci;
    }

    /**
     * Get main sprinkle class name.
     */
    public function getMainSprinkle(): string
    {
        return ($this->mainSprinkle instanceof SprinkleRecipe) ? $this->mainSprinkle::class : $this->mainSprinkle;
    }

    /**
     * Create the container with all sprinkles services definitions.
     *
     * @return Container
     */
    protected function createContainer(): Container
    {
        $frameworkServices = new FrameworkService();

        $builder = new ContainerBuilder();
        $builder->useAttributes(true);
        $builder->addDefinitions($frameworkServices->register());

        // Add all definitions for each sprinkles
        foreach ($this->sprinkleManager->getServicesDefinitions() as $definition) {
            $builder->addDefinitions($definition);
        }

        $ci = $builder->build();

        return $ci;
    }

    /**
     * Instantiate the Slim or Symfony application and return it.
     */
    abstract protected function initiateApp(): void;
}
