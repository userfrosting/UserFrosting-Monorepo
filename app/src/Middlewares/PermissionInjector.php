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

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PermissionInterface;
use UserFrosting\Sprinkle\Admin\Exceptions\PermissionNotFoundException;

/**
 * Route middleware to inject a permission when it's id is passed via placeholder in the URL or request query.
 */
class PermissionInjector extends AbstractInjector
{
    // Route placeholder
    protected string $placeholder = 'id';

    // Middleware attribute name.
    protected string $attribute = 'permission';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected PermissionInterface $model,
    ) {
    }

    /**
     * Returns the permission's instance.
     *
     * @param string|null $id
     *
     * @return PermissionInterface
     */
    protected function getInstance(?string $id): PermissionInterface
    {
        if ($id === null || ($instance = $this->model->find($id)) === null) {
            throw new PermissionNotFoundException();
        }

        // @phpstan-ignore-next-line Role Interface is a model
        return $instance;
    }
}
