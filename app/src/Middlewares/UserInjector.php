<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Middlewares;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Admin\Exceptions\AccountNotFoundException;

/**
 * Route middleware to inject user when it's user_name is passed via placeholder in the URL or request query.
 */
class UserInjector extends AbstractInjector
{
    // Route placeholder
    protected string $placeholder = 'user_name';

    // Middleware attribute name.
    protected string $attribute = 'user';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected UserInterface $model,
    ) {
    }

    /**
     * Returns the user's instance.
     *
     * @param string|null $username
     *
     * @return UserInterface
     */
    protected function getInstance(?string $username): UserInterface
    {
        if ($username === null || ($user = $this->model->where('user_name', $username)->first()) === null) {
            throw new AccountNotFoundException();
        }

        // @phpstan-ignore-next-line Role Interface is a model
        return $user;
    }
}
