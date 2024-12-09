<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\UniformResourceLocator;

/**
 * The representation of a location.
 */
interface ResourceLocationInterface
{
    /**
     * Returns the display name of the Location.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Returns the path for the location.
     * Path should be relative to the main locator path.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Return identifier slug for Location.
     *
     * @return string
     *
     * @deprecated 5.1
     */
    public function getSlug(): string;
}
