<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\Util;

use Countable;
use PHPUnit\Framework\TestCase;
use Traversable;
use UserFrosting\Support\ClassRepository;
use UserFrosting\Support\Exception\ClassNotFoundException;

class ClassRepositoryTest extends TestCase
{
    public function testGetAll(): void
    {
        $repository = new TestClassRepository();
        $classes = $repository->all();

        $this->assertCount(2, $classes);
        $this->assertInstanceOf(StubClassA::class, $classes[0]);
        $this->assertInstanceOf(StubClassB::class, $classes[1]);
    }

    /**
     * @depends testGetAll
     */
    public function testList(): void
    {
        $repository = new TestClassRepository();
        $this->assertSame([
            StubClassA::class,
            StubClassB::class,
        ], $repository->list());
    }

    /**
     * @depends testList
     */
    public function testHas(): void
    {
        $repository = new TestClassRepository();
        $this->assertTrue($repository->has(StubClassA::class));
        $this->assertFalse($repository->has(StubClassC::class));
    }

    /**
     * @depends testHas
     */
    public function testGet(): void
    {
        $repository = new TestClassRepository();
        $class = $repository->get(StubClassA::class);
        $this->assertInstanceOf(StubClassA::class, $class);
    }

    /**
     * @depends testHas
     */
    public function testGetWithNotFound(): void
    {
        $repository = new TestClassRepository();
        $this->expectException(ClassNotFoundException::class);
        $repository->get(StubClassC::class);
    }

    public function testArrayFunctions(): void
    {
        $repository = new TestClassRepository();

        // Countable
        $this->assertInstanceOf(Countable::class, $repository); // @phpstan-ignore-line
        $this->assertCount(2, $repository);
        $this->assertSame(count($repository), $repository->count());

        // Iterable
        $this->assertInstanceOf(Traversable::class, $repository); // @phpstan-ignore-line
        $this->assertIsIterable($repository); // @phpstan-ignore-line

        // Simple way to test loop, otherwise PHPUnit doesn't fail if assertion is not run.
        $count = 0;
        foreach ($repository as $class) {
            $this->assertInstanceOf(FooBar::class, $class); // @phpstan-ignore-line
            $count++;
        }
        $this->assertSame(2, $count);
    }
}

/**
 * @extends ClassRepository<FooBar>
 */
class TestClassRepository extends ClassRepository
{
    public function all(): array
    {
        return [
            new StubClassA(),
            new StubClassB(),
        ];
    }
}

interface FooBar
{
}

class StubClassA implements FooBar
{
}

class StubClassB implements FooBar
{
}

class StubClassC
{
}
