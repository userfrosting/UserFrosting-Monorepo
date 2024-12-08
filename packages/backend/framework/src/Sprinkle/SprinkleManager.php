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

use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Support\Exception\BadClassNameException;
use UserFrosting\Support\Exception\BadInstanceOfException;

/**
 * Sprinkle Manager.
 *
 * Manages a collection of loaded Sprinkles for the application.
 * Returns all the information about the loaded Sprinkles, defined in each SprinkleRecipe.
 * This class does not perform any action on the application itself, it only serves information.
 * All routes, commands or other registration process is handled elsewhere.
 */
class SprinkleManager
{
    /**
     * @var SprinkleRecipe[] List of available sprinkles
     */
    protected array $sprinkles = [];

    /**
     * @var SprinkleRecipe Main sprinkle
     */
    protected SprinkleRecipe $mainSprinkle;

    /**
     * Load sprinkles on construction.
     *
     * @param class-string<SprinkleRecipe>|SprinkleRecipe $mainSprinkle
     */
    public function __construct(string|SprinkleRecipe $mainSprinkle)
    {
        $this->mainSprinkle = $this->validateClassIsRecipe($mainSprinkle);
        $this->loadSprinkles();
    }

    /**
     * Generate the list of all loaded sprinkles through the main sprinkle dependencies.
     */
    public function loadSprinkles(): void
    {
        $this->sprinkles = $this->getDependentSprinkles($this->mainSprinkle);
    }

    /**
     * Returns a list of available sprinkles.
     *
     * @return SprinkleRecipe[]
     */
    public function getSprinkles(): array
    {
        return $this->sprinkles;
    }

    /**
     * Get main sprinkle defined on construction.
     *
     * @return SprinkleRecipe
     */
    public function getMainSprinkle(): SprinkleRecipe
    {
        return $this->mainSprinkle;
    }

    /**
     * Returns a list of available sprinkle names.
     *
     * @return string[]
     */
    public function getSprinklesNames(): array
    {
        return array_map(function (SprinkleRecipe $sprinkle) {
            return $sprinkle->getName();
        }, $this->sprinkles);
    }

    /**
     * Return if a Sprinkle class is available.
     * Can be used by other Sprinkles to test if their dependencies are met.
     *
     * @param class-string<SprinkleRecipe> $sprinkle The class of the Sprinkle
     *
     * @return bool
     */
    public function isAvailable(string $sprinkle): bool
    {
        return array_key_exists($sprinkle, $this->sprinkles);
    }

    /**
     * Returns a list of all PHP-DI services/container definitions, from all sprinkles.
     *
     * @return mixed[][] PHP-DI definitions.
     */
    public function getServicesDefinitions(): array
    {
        $containers = [];

        foreach ($this->sprinkles as $sprinkle) {
            foreach ($sprinkle->getServices() as $provider) {
                $containers[] = $this->validateClassIsServicesProvider($provider)->register();
            }
        }

        return $containers;
    }

    /**
     * Return a list for the specified sprinkle and it's dependent, recursively.
     *
     * @param SprinkleRecipe $sprinkle Sprinkle to load, and it's dependent.
     *
     * @return SprinkleRecipe[]
     */
    protected function getDependentSprinkles(SprinkleRecipe $sprinkle): array
    {
        $sprinkles = [];

        // Merge dependent sprinkles
        foreach ($sprinkle->getSprinkles() as $dependent) {
            $dependent = $this->validateClassIsRecipe($dependent);
            $sprinkles = array_merge($sprinkles, $this->getDependentSprinkles($dependent));
        }

        // Add top sprinkle to return
        $sprinkles[$sprinkle::class] = $sprinkle;

        return $sprinkles;
    }

    /**
     * Instantiate a class string into an instance of SprinkleRecipe.
     * Provides flexibility, allowing string and object to be referenced.
     *
     * @param class-string|SprinkleRecipe $class
     *
     * @throws BadClassNameException  If $class is not found
     * @throws BadInstanceOfException If $class doesn't implement SprinkleRecipe interface.
     *
     * @return SprinkleRecipe
     */
    protected function validateClassIsRecipe(string|SprinkleRecipe $class): SprinkleRecipe
    {
        if (!is_string($class)) {
            return $class;
        }

        if (!class_exists($class)) {
            throw new BadClassNameException("Sprinkle recipe class `$class` not found.");
        }

        // Get class instance
        $instance = new $class();

        // Class must be an instance of SprinkleRecipe
        if (!$instance instanceof SprinkleRecipe) {
            throw new BadInstanceOfException("Class $class is not a valid instance of " . SprinkleRecipe::class);
        }

        return $instance;
    }

    /**
     * Instantiate a class string into an instance of ServicesProviderInterface.
     * Provides flexibility, allowing string and object to be referenced.
     *
     * @param class-string $class
     *
     * @throws BadClassNameException  If $class is not found
     * @throws BadInstanceOfException If $class doesn't implement ServicesProviderInterface interface.
     *
     * @return ServicesProviderInterface
     */
    protected function validateClassIsServicesProvider(string $class): ServicesProviderInterface
    {
        if (!class_exists($class)) {
            throw new BadClassNameException("Services provider class `$class` not found. Make sure the class is correctly defined in your sprinkle's recipe.");
        }

        // Get class instance
        $instance = new $class();

        // Class must be an instance of ServicesProviderInterface
        if (!$instance instanceof ServicesProviderInterface) {
            throw new BadInstanceOfException("$class is not a valid ServicesProviderInterface");
        }

        return $instance;
    }
}
