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

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupNotFoundException;
use UserFrosting\Sprinkle\Core\Middlewares\Injector\AbstractInjector;

/**
 * Route middleware to inject group when it's slug is passed via placeholder in the URL or request query.
 */
class GroupInjector extends AbstractInjector
{
    // Middleware attribute name.
    protected string $attribute = 'group';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected GroupInterface $model,
    ) {
    }

    /**
     * Returns the group's instance.
     *
     * @param string|null $slug
     *
     * @return GroupInterface
     */
    protected function getInstance(?string $slug): GroupInterface
    {
        if ($slug === null || ($group = $this->model->where('slug', $slug)->first()) === null) {
            throw new GroupNotFoundException();
        }

        // @phpstan-ignore-next-line Role Interface is a model
        return $group;
    }
}
