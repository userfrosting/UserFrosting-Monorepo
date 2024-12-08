<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Helpers;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;

trait DynamicUserModel
{
    /**
     * Get user Model to use.
     *
     * @return UserInterface
     */
    public function getUserModel(): UserInterface
    {
        return $this->userModel;
    }

    /**
     * Set user Model to use.
     *
     * @param UserInterface $userModel User Model to use.
     *
     * @return static
     */
    public function setUserModel(UserInterface $userModel): static
    {
        $this->userModel = $userModel;

        return $this;
    }
}
