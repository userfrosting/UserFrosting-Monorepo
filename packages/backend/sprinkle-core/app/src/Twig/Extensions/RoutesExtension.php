<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use UserFrosting\Sprinkle\Core\Util\RouteParserInterface;

class RoutesExtension extends AbstractExtension
{
    /**
     * @param RouteParserInterface $routeParser
     */
    public function __construct(protected RouteParserInterface $routeParser)
    {
    }

    /**
     * Adds Twig functions `urlFor`.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('urlFor', [$this->routeParser, 'urlFor']),
        ];
    }
}
