<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Session;

use Illuminate\Session\ExistenceAwareInterface;
use Illuminate\Session\NullSessionHandler;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use SessionHandlerInterface;
use UserFrosting\Session\Session;

class SessionTest extends TestCase
{
    /**
     * @var SessionHandlerInterface
     */
    protected SessionHandlerInterface $handler;

    public function setUp(): void
    {
        $this->handler = new NullSessionHandler();
    }

    public function testGetHandler(): void
    {
        $session = $this->getSession();
        $this->assertEquals($this->handler, $session->getHandler());
    }

    public function testSessionStartAndDestroy(): void
    {
        $session = $this->getSession();

        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
        $session->destroy(false);
        $this->assertSame(PHP_SESSION_NONE, $session->status());
        $session->start();
        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
    }

    public function testSessionDestroyWithDestroyCookie(): void
    {
        $session = $this->getSession();

        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
        $session->destroy();
        $this->assertSame(PHP_SESSION_NONE, $session->status());
    }

    public function testSessionWithArrayParam(): void
    {
        $session = new Session($this->handler, [
            'cookie_parameters' => ['lifetime' => 180]
        ]);
        $session->start();
        $this->assertSame(PHP_SESSION_ACTIVE, $session->status());
        $session->destroy();
        $this->assertSame(PHP_SESSION_NONE, $session->status());
    }

    public function testSessionRegenerateId(): void
    {
        $session = $this->getSession();

        $id = $session->getId();
        $session->regenerateId();
        $newId = $session->getId();

        $this->assertNotSame($id, $newId);
    }

    public function testSessionStorage(): void
    {
        $session = $this->getSession();

        $this->assertFalse($session->has('foo'));
        $session->set('foo', 'bar');
        $this->assertTrue($session->has('foo'));
        $this->assertSame('bar', $session->get('foo'));
        $this->assertSame(['foo' => 'bar'], $session->all());
    }

    public function testSessionStorageSetWithArray(): void
    {
        $session = $this->getSession();

        $data = [
            'foo' => 'bar',
            'bar' => 'foo',
        ];

        $this->assertFalse($session->has('foo'));
        $session->set($data);
        $this->assertTrue($session->has('foo'));
        $this->assertSame('bar', $session->get('foo'));
        $this->assertSame($data, $session->all());
    }

    public function testSessionStoragePush(): void
    {
        $session = $this->getSession();
        $data = ['foo', 'bar'];

        $session->set('data', $data);

        $this->assertIsArray($session->get('data'));
        $this->assertCount(2, $session->get('data'));
        $session->push('data', 'blah');
        $this->assertIsArray($session->get('data'));
        $this->assertCount(3, $session->get('data'));
        $this->assertSame('blah', $session->get('data')[2]);
    }

    public function testSessionStoragePrepend(): void
    {
        $session = $this->getSession();
        $data = ['foo', 'bar'];

        $session->set('data', $data);

        $this->assertIsArray($session->get('data'));
        $this->assertCount(2, $session->get('data'));
        $session->prepend('data', 'blah');
        $this->assertIsArray($session->get('data'));
        $this->assertCount(3, $session->get('data'));
        $this->assertSame('blah', $session->get('data')[0]);
    }

    public function testSessionStorageArrayAccess(): void
    {
        $session = $this->getSession();

        $this->assertFalse(isset($session['foo']));
        $session['foo'] = 'bar';
        $this->assertTrue(isset($session['foo']));
        $this->assertSame('bar', $session['foo']);
        unset($session['foo']);
        $this->assertFalse(isset($session['foo']));
        $this->assertNull($session['foo']);
    }

    public function testSessionStorageDotNotation(): void
    {
        $session = $this->getSession();

        // Set base data
        $session->set([
            'data' => [
                'foo' => 'bar',
            ],
        ]);

        // Assert basic methods
        $this->assertTrue($session->has('data.foo'));
        $this->assertSame('bar', $session->get('data.foo'));

        // Again with ArrayAccess
        $this->assertTrue(isset($session['data.foo']));
        $this->assertSame('bar', $session['data.foo']);

        // Assert set dot notation
        $session->set('data.bar', 'foo');
        $this->assertTrue($session->has('data.bar'));
        $this->assertSame('foo', $session->get('data.bar'));

        // Assert set with dot set the array properly
        $this->assertSame([
            'data' => [
                'foo' => 'bar',
                'bar' => 'foo',
            ],
        ], $session->all());

        // Assert forget
        $session->forget('data.bar');
        $this->assertFalse($session->has('data.bar'));

        // Again with ArrayAccess
        $session['data.bar'] = 'foobar';
        $this->assertTrue(isset($session['data.bar']));
        $this->assertSame('foobar', $session['data.bar']);
        unset($session['data.bar']);
        $this->assertFalse(isset($session['data.bar']));

        // Assert push/prepend
        $session->set('data.config', ['foobar']);
        $session->prepend('data.config', 'foo');
        $session->push('data.config', 'bar');
        $this->assertSame(['foo', 'foobar', 'bar'], $session->get('data.config'));
    }

    public function testPrependOnNonArray(): void
    {
        $session = $this->getSession();
        $session->set('foo', 'bar');
        $this->expectException(InvalidArgumentException::class);
        $session->prepend('foo', 'blah');
    }

    public function testPushOnNonArray(): void
    {
        $session = $this->getSession();
        $session->set('foo', 'bar');
        $this->expectException(InvalidArgumentException::class);
        $session->push('foo', 'blah');
    }

    public function testSetExistsWithExistenceAware(): void
    {
        $handler = new ExistenceAwareNullSessionHandlerStub();
        $session = new Session($handler, $this->sessionConfig());

        $this->assertFalse($handler->getExists());
        $session->setExists(true);
        $this->assertTrue($handler->getExists());
    }

    /**
     * @return Session
     */
    protected function getSession(): Session
    {
        $session = new Session($this->handler, $this->sessionConfig());
        $session->destroy();
        $session->start();

        return $session;
    }

    /**
     * @return array<string, int|bool|string>
     */
    protected function sessionConfig(): array
    {
        return [
            'cache_limiter'     => false,
            'cache_expire'      => 180,
            'name'              => 'sessionTests',
            'cookie_parameters' => 180,
        ];
    }
}

class ExistenceAwareNullSessionHandlerStub extends NullSessionHandler implements ExistenceAwareInterface
{
    /**
     * @var bool
     */
    protected bool $exists = false;

    public function setExists($value)
    {
        $this->exists = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function getExists(): bool
    {
        return $this->exists;
    }
}
