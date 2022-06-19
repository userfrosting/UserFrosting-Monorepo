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

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleNotFoundException;

/**
 * Route middleware to inject role when it's slug is passed via placeholder in the URL or request query.
 */
class RoleInjector extends AbstractInjector
{
    // Middleware attribute name.
    protected string $attribute = 'role';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected RoleInterface $model,
    ) {
    }

    /**
     * Returns the role's instance.
     *
     * @param string|null $slug
     *
     * @return RoleInterface
     */
    protected function getInstance(?string $slug): RoleInterface
    {
        if ($slug === null || ($role = $this->model->where('slug', $slug)->first()) === null) {
            throw new RoleNotFoundException();
        }

        // @phpstan-ignore-next-line Role Interface is a model
        return $role;
    }
}
