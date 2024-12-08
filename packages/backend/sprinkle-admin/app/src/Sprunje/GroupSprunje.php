<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Sprunje;

use Illuminate\Database\Eloquent\Model;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * Implements Sprunje for the groups API.
 */
class GroupSprunje extends Sprunje
{
    protected string $name = 'groups';

    protected array $sortable = [
        'name',
        'description',
    ];

    protected array $filterable = [
        'name',
        'description',
    ];

    public function __construct(
        protected GroupInterface $model,
    ) {
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery()
    {
        // @phpstan-ignore-next-line Model implement Model.
        return $this->model;
    }
}
