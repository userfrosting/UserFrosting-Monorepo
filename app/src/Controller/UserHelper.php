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
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Exceptions\AccountNotFoundException;
use UserFrosting\Sprinkle\Core\Exceptions\ValidationException;

/**
 * Helper class when a user is defined by username in the URL.
 * @todo : This could probably be middleware ?
 */
class UserHelper
{
    protected string $schema = 'schema://requests/user/get-by-username.yaml';

    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Translator $translator,
        protected UserInterface $userModel,
    ) {
    }

    /**
     * Get User instance from params.
     *
     * @param string[] $params
     *
     * @throws ValidationException
     * @throws AccountNotFoundException If user is not found.
     *
     * @return UserInterface
     */
    public function getUser(array $params): UserInterface
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
        /** @var null|UserInterface */
        $user = $this->userModel->where('user_name', $data['user_name'])->first();

        // If the user doesn't exist, return 404
        if ($user === null) {
            throw new AccountNotFoundException('User not found');
        }

        return $user;
    }
}
