<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Authenticate\Interfaces;

/**
 * Password hashing and validation class.
 */
interface HasherInterface
{
    /**
     * Returns the hashing type for a specified password hash.
     *
     * @param string $password the hashed password.
     *
     * @return string
     */
    public function getHashType(string $password): string;

    /**
     * Hashes a plaintext password using bcrypt.
     *
     * @param string $password the plaintext password.
     *
     * @return string the hashed password.
     */
    public function hash(string $password): string;

    /**
     * Verify a plaintext password against the user's hashed password.
     *
     * @param string $password The plaintext password to verify.
     * @param string $hash     The hash to compare against.
     *
     * @return bool True if the password matches, false otherwise.
     */
    public function verify(string $password, string $hash): bool;

    /**
     * Get default crypt cost factor.
     *
     * @return int
     */
    public function getCount(): int;

    /**
     * Set default crypt cost factor.
     *
     * @param int $cost Default crypt cost factor.
     *
     * @return static
     */
    public function setCount(int $cost): static;
}
