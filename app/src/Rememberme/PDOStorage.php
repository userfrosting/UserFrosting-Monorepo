<?php

declare(strict_types=1);

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Rememberme;

use Birke\Rememberme\Storage\StorageInterface;
use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Account\Database\Models\Persistence;

/**
 * Store login tokens in database with PDO class.
 */
class PDOStorage implements StorageInterface
{
    /**
     * @param Capsule $db
     */
    public function __construct(protected Capsule $db)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function findTriplet($credential, $token, $persistentToken): int
    {
        /** @var Persistence|null */
        $result = Persistence::notExpired()->where([
            'user_id'          => $credential,
            'persistent_token' => sha1($persistentToken),
        ])->first();

        if ($result === null) {
            return self::TRIPLET_NOT_FOUND;
        } elseif ($result->token === sha1($token)) {
            return self::TRIPLET_FOUND;
        }

        return self::TRIPLET_INVALID;
    }

    /**
     * {@inheritdoc}
     */
    public function storeTriplet($credential, $token, $persistentToken, $expire = 0): void
    {
        $persistence = new Persistence([
            'user_id'          => $credential,
            'token'            => sha1($token),
            'persistent_token' => sha1($persistentToken),
            'expires_at'       => date('Y-m-d H:i:s', $expire),
        ]);
        $persistence->save();
    }

    /**
     * {@inheritdoc}
     */
    public function cleanTriplet($credential, $persistentToken): void
    {
        Persistence::where([
            'user_id'          => $credential,
            'persistent_token' => sha1($persistentToken),
        ])->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function replaceTriplet($credential, $token, $persistentToken, $expire = 0): void
    {
        // @phpstan-ignore-next-line Transaction is handled using __callStatic in Capsule
        Capsule::transaction(function () use ($credential, $token, $persistentToken, $expire) {
            $this->cleanTriplet($credential, $persistentToken);
            $this->storeTriplet($credential, $token, $persistentToken, $expire);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function cleanAllTriplets($credential): void
    {
        Persistence::where('user_id', $credential)->delete();
    }

    /**
     * {@inheritdoc}
     */
    public function cleanExpiredTokens($expiryTime): void
    {
        Persistence::where('expires_at', '<', date('Y-m-d H:i:s', $expiryTime))->delete();
    }
}
