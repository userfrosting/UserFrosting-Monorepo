<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\TwigExtensionRecipe;
use UserFrosting\Sprinkle\Core\Twig\SprinkleTwigRepository;
use UserFrosting\Sprinkle\Core\Twig\TwigRepositoryInterface;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/*
 * Set up Twig as the view, adding template paths for all sprinkles and the Slim Twig extension.
 *
 * Also adds the UserFrosting core Twig extension, which provides additional functions, filters, global variables, etc.
 */
class TwigService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            Twig::class => function (
                ResourceLocatorInterface $locator,
                Config $config,
                TwigRepositoryInterface $extensionLoader,
                FilesystemLoader $loader,
            ) {
                $twig = new Twig($loader);
                $twigEnv = $twig->getEnvironment();

                // Optionally set cache
                if (boolval($config->get('cache.twig'))) {
                    $resource = $locator->getResource('cache://twig', true);
                    $path = $resource?->getAbsolutePath() ?? false;
                    $twigEnv->setCache($path);
                }

                // Optionally enable debug
                if (boolval($config->get('debug.twig'))) {
                    $twigEnv->enableDebug();
                    $twig->addExtension(new DebugExtension());
                }

                // Register Twig extensions
                $this->registerTwigExtensions($twig, $extensionLoader);

                return $twig;
            },

            FilesystemLoader::class => function (ResourceLocatorInterface $locator) {
                $loader = new FilesystemLoader();

                // Add Sprinkles' templates namespaces, as a main path and a namespaced path
                foreach ($locator->getResources('templates://') as $templateResource) {
                    $loader->addPath($templateResource->getAbsolutePath());
                    $loader->addPath(
                        $templateResource->getAbsolutePath(),
                        $templateResource->getLocation()?->getName() ?? ''
                    );
                }

                return $loader;
            },

            TwigMiddleware::class => function (App $app, Twig $twig) {
                return TwigMiddleware::create($app, $twig);
            },

            TwigRepositoryInterface::class => \DI\autowire(SprinkleTwigRepository::class),
        ];
    }

    /**
     * Register all Twig Extensions defined in Sprinkles TwigExtensionRecipe.
     *
     * @param Twig                    $twig
     * @param TwigRepositoryInterface $extensionLoader
     */
    protected function registerTwigExtensions(Twig $twig, TwigRepositoryInterface $extensionLoader): void
    {
        foreach ($extensionLoader as $extension) {
            $twig->addExtension($extension);
        }
    }
}
