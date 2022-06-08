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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Admin\Exceptions\GroupNotFoundException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Helper class when a group is defined by slug in the URL.
 *
 * @todo : This could probably be middleware ?
 */
class GroupHelper
{
    protected string $schema = 'schema://requests/group/get-by-slug.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected GroupInterface $model,
    ) {
    }

    /**
     * Get Group instance from params.
     *
     * @param string[] $params
     *
     * @throws ValidationException
     * @throws AccountNotFoundException If group is not found.
     *
     * @return GroupInterface
     */
    public function getGroup(array $params): GroupInterface
    {
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
        /** @var null|GroupInterface */
        $user = $this->model->where('slug', $data['slug'])->first();

        // If the user doesn't exist, return 404
        if ($user === null) {
            throw new GroupNotFoundException('Group not found');
        }

        return $user;
    }
}
