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
use UserFrosting\Config\Config;

class ConfigExtension extends AbstractExtension
{
    /**
     * @param Config $config
     */
    public function __construct(protected Config $config)
    {
    }

    /**
     * Adds Twig functions `config`.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('config', [$this->config, 'get']),
        ];
    }
}
