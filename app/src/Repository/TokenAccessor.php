<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Repository;

/**
 * Interface for Token setter and getter class or model.
 */
interface TokenAccessor
{
    /**
     * @return string
     */
    public function getToken(): string;

    /**
     * @param string $value
     *
     * @return static
     */
    public function setToken(string $value): static;
}
