<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Validators;

use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\User;
use UserFrosting\Sprinkle\Account\Exceptions\EmailNotUniqueException;
use UserFrosting\Sprinkle\Account\Exceptions\MissingRequiredParamException;
use UserFrosting\Sprinkle\Account\Exceptions\UsernameNotUniqueException;
use UserFrosting\Sprinkle\Account\Facades\Password;
use UserFrosting\Sprinkle\Account\Helpers\DynamicUserModel;

/**
 * Process server side validation for the UserInterface Model.
 *
 * This should be used checks that can only be done server side. Other check
 * should be done inside the RequestSchema.
 */
class UserValidation
{
    use DynamicUserModel;

    /**
     * @var string[] The required properties to create a new user.
     */
    protected array $requiredProperties = [
        'user_name',
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * @param UserInterface $userModel The User Model to use to fetch User
     */
    public function __construct(protected UserInterface $userModel)
    {
    }

    /**
     * Validate the user has all the required value before creation/update.
     *
     * @throws MissingRequiredParamException If required user field is missing
     * @throws UsernameNotUniqueException    If username is already in use
     * @throws EmailNotUniqueException       If email is already in use
     *
     * @return bool Returns true if the data is valid
     */
    public function validate(UserInterface $user): bool
    {
        // Make sure all required fields are defined
        foreach ($this->requiredProperties as $property) {
            // @phpstan-ignore-next-line False positive. That's the point of the test
            if ($user->$property === null) {
                $e = new MissingRequiredParamException();
                $e->setParam($property);

                throw $e;
            }
        }

        // Check if username is unique
        // TODO : Ignore self (in case)
        if (!$this->usernameIsUnique($user->user_name)) {
            $e = new UsernameNotUniqueException();
            $e->setUsername($user->user_name);

            throw $e;
        }

        // Check if email is unique
        // TODO : Ignore self (in case)
        if (!$this->emailIsUnique($user->email)) {
            $e = new EmailNotUniqueException();
            $e->setEmail($user->email);

            throw $e;
        }

        // Validate password requirements
        // TODO

        return true;
    }

    /**
     * Check Unique Username. Make sure the username is not already in use.
     *
     * @param string $username
     *
     * @return bool Return true if username is unique
     */
    public function usernameIsUnique(string $username): bool
    {
        return $this->userModel::findUnique($username, 'user_name') === null;
    }

    /**
     * Check Unique Email. Make sure the email is not already in use.
     *
     * @param string $email
     *
     * @return bool Return true if email is unique
     */
    public function emailIsUnique(string $email): bool
    {
        return $this->userModel::findUnique($email, 'email') === null;
    }

    /**
     * Get the required properties to create a new user.
     *
     * @return string[]
     */
    public function getRequiredProperties(): array
    {
        return $this->requiredProperties;
    }

    /**
     * Set the required properties to create a new user.
     *
     * @param string[] $requiredProperties
     *
     * @return static
     */
    public function setRequiredProperties(array $requiredProperties): static
    {
        $this->requiredProperties = $requiredProperties;

        return $this;
    }

    /**
     * Add property to the required list.
     *
     * @return static
     */
    public function addRequiredProperty(string $property): static
    {
        $this->requiredProperties[] = $property;

        return $this;
    }
}
