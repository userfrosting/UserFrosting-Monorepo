<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Exceptions\Contracts;

interface TwigRenderedException
{
    /**
     * Return Twig Template to use to render exception using TwigPageRenderer.
     *
     * @return string
     */
    public function getTemplate(): string;
}
