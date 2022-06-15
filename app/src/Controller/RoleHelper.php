<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller;

use UserFrosting\Fortress\RequestDataTransformer;
use UserFrosting\Fortress\RequestSchema;
use UserFrosting\Fortress\ServerSideValidator;
use UserFrosting\I18n\Translator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Admin\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Admin\Exceptions\RoleNotFoundException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Helper class when a user is defined by username in the URL.
 *
 * @todo : This could probably be middleware ?
 */
class RoleHelper
{
    protected string $schema = 'schema://requests/role/get-by-slug.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected RoleInterface $model,
    ) {
    }

    /**
     * Get Role instance from params.
     *
     * @param string[] $params
     *
     * @throws ValidationException
     * @throws AccountNotFoundException If user is not found.
     *
     * @return RoleInterface
     */
    public function __invoke(array|string $params): RoleInterface
    {
        if (is_string($params)) {
            $params = ['slug' => $params];
        }

        // Load the request schema
        $schema = new RequestSchema($this->schema);

        // Whitelist and set parameter defaults
        $transformer = new RequestDataTransformer($schema);
        $data = $transformer->transform($params);

        // Validate, and throw exception on validation errors.
        $validator = new ServerSideValidator($schema, $this->translator);
        if ($validator->validate($data) === false && is_array($validator->errors())) {
            $e = new ValidationException();
            $e->addErrors($validator->errors());

            throw $e;
        }

        // Get the user to delete
        /** @var null|RoleInterface */
        $role = $this->model->where('slug', $data['slug'])->first();

        // If the user doesn't exist, return 404
        if ($role === null) {
            throw new RoleNotFoundException('Role not found');
        }

        return $role;
    }
}
