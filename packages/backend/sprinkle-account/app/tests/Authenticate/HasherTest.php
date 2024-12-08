<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account\Tests\Authenticate;

use PHPUnit\Framework\TestCase;
use UserFrosting\Sprinkle\Account\Authenticate\Hasher;

/**
 * Tests the password Hasher class.
 */
class HasherTest extends TestCase
{
    /**
     * @var string
     */
    protected string $plainText = 'hodleth';

    /**
     * @var string Legacy hash from UserCake (sha1)
     */
    protected string $userCakeHash = '87e995bde9ebdc73fc58cc75a9fadc4ae630d8207650fbe94e148ccc8058d5de5';

    /**
     * @var string Legacy hash from UF 0.1.x
     */
    protected string $legacyHash = '$2y$12$rsXGznS5Ky23lX9iNzApAuDccKRhQFkiy5QfKWp0ACyDWBPOylPB.rsXGznS5Ky23lX9iNzApA9';

    /**
     * @var string Modern hash that uses password_hash()
     */
    protected string $modernHash = '$2y$10$ucxLwloFso6wJoct1baBQefdrttws/taEYvavi6qoPsw/vd1u4Mha';

    public function testGetterSetter(): void
    {
        $hasher = new Hasher();
        $this->assertSame(25, $hasher->setCount(25)->getCount());
    }

    public function testGetHashType(): void
    {
        $hasher = new Hasher();

        $this->assertSame('modern', $hasher->getHashType($this->modernHash));
        $this->assertSame('legacy', $hasher->getHashType($this->legacyHash));
        $this->assertSame('sha1', $hasher->getHashType($this->userCakeHash));
    }

    public function testVerify(): void
    {
        $hasher = new Hasher();

        $this->assertTrue($hasher->verify($this->plainText, $this->modernHash));
        $this->assertTrue($hasher->verify($this->plainText, $this->legacyHash));
        $this->assertTrue($hasher->verify($this->plainText, $this->userCakeHash));
    }

    public function testHash(): void
    {
        $hasher = new Hasher();

        $this->assertTrue($hasher->verify($this->plainText, $hasher->hash($this->plainText)));
    }

    public function testVerifyReject(): void
    {
        $hasher = new Hasher();

        $this->assertFalse($hasher->verify('selleth', $this->modernHash));
        $this->assertFalse($hasher->verify('selleth', $this->legacyHash));
        $this->assertFalse($hasher->verify('selleth', $this->userCakeHash));
    }
}
