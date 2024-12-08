<?php

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

use PHPUnit\Framework\TestCase;
use UserFrosting\Config\Config;
use UserFrosting\Config\TypeException;

class ConfigTest extends TestCase
{
    /** @var array<string,mixed> */
    protected array $data = [
        'bool'   => true,
        'string' => 'foobar',
        'int'    => 92,
        'array'  => ['foo', 'bar'],
        'null'   => null,
    ];

    public function testGetBool(): void
    {
        $repo = new Config($this->data);

        $this->assertSame(true, $repo->getBool('bool'));
        $this->assertSame(false, $repo->getBool('missing', false));
        $this->assertSame(null, $repo->getBool('missing'));
        $this->assertSame($repo->get('missing'), $repo->getBool('missing')); // Same default behavior as "get"

        // Value is null, but not the default. Default should still be used.
        $this->assertSame(null, $repo->getBool('null'));
        $this->assertSame(false, $repo->getBool('null', false));

        // Exception
        $this->expectException(TypeException::class);
        $repo->getBool('string');
    }

    public function testGetString(): void
    {
        $repo = new Config($this->data);

        $this->assertSame('foobar', $repo->getString('string'));
        $this->assertSame('barfoo', $repo->getString('missing', 'barfoo'));
        $this->assertSame(null, $repo->getString('missing'));
        $this->assertSame($repo->get('missing'), $repo->getString('missing')); // Same default behavior as "get"

        // Value is null, but not the default. Default should still be used.
        $this->assertSame(null, $repo->getString('null'));
        $this->assertSame('non-null', $repo->getString('null', 'non-null'));

        // Exception
        $this->expectException(TypeException::class);
        $repo->getString('bool');
    }

    public function testGetInt(): void
    {
        $repo = new Config($this->data);

        $this->assertSame(92, $repo->getInt('int'));
        $this->assertSame(29, $repo->getInt('missing', 29));
        $this->assertSame(null, $repo->getInt('missing'));
        $this->assertSame($repo->get('missing'), $repo->getInt('missing')); // Same default behavior as "get"

        // Value is null, but not the default. Default should still be used.
        $this->assertSame(null, $repo->getInt('null'));
        $this->assertSame(123, $repo->getInt('null', 123));

        // Exception
        $this->expectException(TypeException::class);
        $repo->getInt('string');
    }

    public function testGetArray(): void
    {
        $repo = new Config($this->data);

        $this->assertSame(['foo', 'bar'], $repo->getArray('array'));
        $this->assertSame(['bar', 'foo'], $repo->getArray('missing', ['bar', 'foo']));
        $this->assertSame(null, $repo->getArray('missing'));
        $this->assertSame($repo->get('missing'), $repo->getArray('missing')); // Same default behavior as "get"

        // Value is null, but not the default. Default should still be used.
        $this->assertSame(null, $repo->getArray('null'));
        $this->assertSame(['non-null'], $repo->getArray('null', ['non-null']));

        // Exception
        $this->expectException(TypeException::class);
        $repo->getArray('string');
    }
}
