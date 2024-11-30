<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Repository;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\PasswordResetInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\VerificationInterface;

/**
 * An abstract class for interacting with a repository of time-sensitive user tokens.
 * User tokens are used, for example, to perform password resets and new account email verifications.
 *
 * @template TModel of PasswordResetInterface|VerificationInterface
 */
abstract class TokenRepository
{
    /**
     * @var string
     */
    protected string $algorithm = 'sha512';

    /**
     * Cancels a specified token by removing it from the database.
     *
     * @param string $token The token to remove.
     *
     * @return bool
     */
    public function cancel(string $token): bool
    {
        // Hash the password reset token for the stored version
        $hash = hash($this->algorithm, $token);

        // Find an incomplete reset request for the specified hash
        /** @var TModel|null */
        $model = $this->getModelIdentifier()
            ->where('hash', $hash)
            ->where('completed', false)
            ->first();

        if ($model === null) {
            return false;
        }

        $model->delete();

        return true;
    }

    /**
     * Completes a token-based process, invoking updateUser() in the child object to do the actual action.
     *
     * @param string  $token      The token to complete.
     * @param mixed[] $userParams An optional list of parameters to pass to updateUser().
     *
     * @return bool True on success
     */
    public function complete(string $token, array $userParams = []): bool
    {
        // Hash the token for the stored version
        $hash = hash($this->algorithm, $token);

        // Find an unexpired, incomplete token for the specified hash
        /** @var TModel|null */
        $model = $this->getModelIdentifier()
            ->where('hash', $hash)
            ->where('completed', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($model === null) {
            return false;
        }

        // Fetch user for this token
        $user = $model->user;

        if (is_null($user)) {
            return false;
        }

        $this->updateUser($user, $userParams);

        $model->fill([
            'completed'    => true,
            'completed_at' => Carbon::now(),
        ]);

        $model->save();

        return true;
    }

    /**
     * Create a new token for a specified user.
     *
     * @param UserInterface $user    The user object to associate with this token.
     * @param int           $timeout The time, in seconds, after which this token should expire.
     *
     * @return TokenAccessor The model (PasswordReset, Verification, etc) object that stores the token.
     */
    public function create(UserInterface $user, int $timeout): TokenAccessor
    {
        // Remove any previous tokens for this user
        $this->removeExisting($user);

        // Compute expiration time
        $expiresAt = Carbon::now()->addSeconds($timeout);

        /** @var TModel */
        $model = $this->getModelIdentifier();

        // Generate a random token
        $token = $this->generateRandomToken();
        $model->setToken($token);

        // Hash the password reset token for the stored version
        $hash = hash($this->algorithm, $model->getToken());

        $model->fill([
            'hash'       => $hash,
            'completed'  => false,
            'expires_at' => $expiresAt,
        ]);

        $model->user_id = $user->id;

        $model->save();

        return $model;
    }

    /**
     * Determine if a specified user has an incomplete and unexpired token.
     *
     * @param UserInterface $user  The user object to look up.
     * @param string|null   $token Optionally, try to match a specific token.
     *
     * @return bool
     */
    public function exists(UserInterface $user, ?string $token = null): bool
    {
        /** @var TModel */
        $model = $this->getModelIdentifier()
            ->where('user_id', $user->id)
            ->where('completed', false)
            ->where('expires_at', '>', Carbon::now());

        if ($token !== null) {
            // get token hash
            $hash = hash($this->algorithm, $token);
            $model->where('hash', $hash);
        }

        return $model->exists() ? true : false;
    }

    /**
     * Validate token is valid and unexpired.
     *
     * @param string $token
     *
     * @return bool
     */
    public function validate(string $token): bool
    {
        // Hash the token for the stored version
        $hash = hash($this->algorithm, $token);

        // Find an unexpired, incomplete token for the specified hash
        /** @var TModel|null */
        $model = $this->getModelIdentifier()
            ->where('hash', $hash)
            ->where('completed', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($model === null) {
            return false;
        }

        return true;
    }

    /**
     * Delete all existing tokens from the database for a particular user.
     *
     * @param UserInterface $user
     */
    protected function removeExisting(UserInterface $user): void
    {
        $this->getModelIdentifier()
             ->where('user_id', $user->id)
             ->delete();
    }

    /**
     * Remove all expired tokens from the database.
     *
     * @return int
     */
    public function removeExpired(): int
    {
        // @phpstan-ignore-next-line False positive. Delete is called from Illuminate\Database\Query\Builder, which return int.
        return $this->getModelIdentifier()
            ->where('completed', false)
            ->where('expires_at', '<', Carbon::now())
            ->delete();
    }

    /**
     * Generate a new random token for this user.
     *
     * This generates a token to use for verifying a new account, resetting a lost password, etc.
     *
     * @param string|null $gen specify an existing token that, if we happen to generate the same value, we should regenerate on.
     *
     * @return string
     */
    protected function generateRandomToken(?string $gen = null): string
    {
        do {
            $gen = md5(uniqid((string) mt_rand(), false));
        } while ($this->getModelIdentifier()->where('hash', hash($this->algorithm, $gen))->first());

        return $gen;
    }

    /**
     * Get the value of algorithm.
     *
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * Set the value of algorithm.
     *
     * @param string $algorithm
     *
     * @return static
     */
    public function setAlgorithm(string $algorithm): static
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * Modify the user during the token completion process.
     *
     * This method is called during complete(), and is a way for concrete implementations to modify the user.
     *
     * @param UserInterface $user the user object to modify.
     * @param mixed[]       $args
     */
    abstract protected function updateUser(UserInterface $user, array $args): void;

    /**
     * Return the model to use for this repository.
     *
     * @return TModel
     */
    abstract protected function getModelIdentifier();
}
