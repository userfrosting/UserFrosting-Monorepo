<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\UniformResourceLocator;

use BadMethodCallException;
use PHPUnit\Framework\TestCase;
use UserFrosting\UniformResourceLocator\Normalizer;

/**
 * Tests for ResourceLocator.
 */
class NormalizerTest extends TestCase
{
    /**
     * @param string      $uri
     * @param string|bool $path Expected result
     * @dataProvider normalizeProvider
     */
    public function testNormalize(string $uri, $path): void
    {
        $this->assertEquals($path, Normalizer::normalize($uri));
    }

    /**
     * Data provider for testNormalize.
     *
     * @return string[][]
     */
    public static function normalizeProvider(): array
    {
        return [
            ['', ''],
            ['./', ''],
            ['././/./', ''],
            ['/', '/'],
            ['//', '/'],
            ['///', '/'],
            ['/././', '/'],
            ['foo', 'foo'],
            ['/foo', '/foo'],
            ['//foo', '/foo'],
            ['/foo/', '/foo/'],
            ['//foo//', '/foo/'],
            ['path/to/file.txt', 'path/to/file.txt'],
            ['path/to/../file.txt', 'path/file.txt'],
            ['path/to/../../file.txt', 'file.txt'],
            ['/path/to/file.txt', '/path/to/file.txt'],
            ['/path/to/../file.txt', '/path/file.txt'],
            ['/path/to/../../file.txt', '/file.txt'],
            ['c:\\', 'c:/'],
            ['c:\\bar\\foo', 'c:/bar/foo'],
            ['c:\\bar/foo', 'c:/bar/foo'],
            ['c:\\path\\to\file.txt', 'c:/path/to/file.txt'],
            ['c:\\path\\to\../file.txt', 'c:/path/file.txt'],
            ['c:\\path\\to\../../file.txt', 'c:/file.txt'],
            ['\\path\\to\file.txt', '/path/to/file.txt'],
            ['\\path/to\file.txt', '/path/to/file.txt'],
            ['stream://path/to/file.txt', 'stream://path/to/file.txt'],
            ['stream://path/to/../file.txt', 'stream://path/file.txt'],
            ['stream://path/to/../../file.txt', 'stream://file.txt'],
        ];
    }

    /**
     * @dataProvider normalizeWithExceptionProvider
     *
     * @param string $uri
     */
    public function testNormalizeThrowExceptionOnBadUriPart(string $uri): void
    {
        $this->expectException(BadMethodCallException::class);
        Normalizer::normalize($uri);
    }

    /**
     * Data provider for testNormalizeThrowExceptionOnBadUriPart.
     *
     * @return string[][]
     */
    public static function normalizeWithExceptionProvider(): array
    {
        return [
            ['path/to/../../../file.txt'],
            ['././/../'],
            ['/path/to/../../../file.txt'],
            ['path/to/../../../file.txt'],
            ['c:\\path\\to\../../../file.txt'],
            ['stream://path/to/../../../file.txt'],
        ];
    }

    /**
     * @param string      $uri
     * @param string|bool $path Expected result
     * @dataProvider normalizePathProvider
     */
    public function testNormalizePath(string $uri, $path): void
    {
        $this->assertEquals($path, Normalizer::normalizePath($uri));
    }

    /**
     * Data provider for testNormalize.
     *
     * @return string[][]
     */
    public static function normalizePathProvider(): array
    {
        return [
            ['', ''],
            ['./', ''],
            ['/', '/'],
            ['//', '/'],
            ['///', '/'],
            ['foo', 'foo/'],
            ['/foo', '/foo/'],
            ['//foo', '/foo/'],
            ['/foo/', '/foo/'],
            ['//foo//', '/foo/'],
            ['c:\\', 'c:/'],
            ['c:\\bar\\foo', 'c:/bar/foo/'],
            ['c:\\bar/foo', 'c:/bar/foo/'],
        ];
    }
}
