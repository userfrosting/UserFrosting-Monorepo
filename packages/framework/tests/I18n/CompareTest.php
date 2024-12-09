<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\I18n;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use UserFrosting\I18n\Compare;
use UserFrosting\I18n\DictionaryInterface;

class CompareTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @var DictionaryInterface
     */
    protected DictionaryInterface $left;

    /**
     * @var DictionaryInterface
     */
    protected DictionaryInterface $right;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->left = Mockery::mock(DictionaryInterface::class);
        $this->left->shouldReceive('getFlattenDictionary')->andReturn([
            'Foo'               => 'Bar',
            'test.@TRANSLATION' => 'Test',
            'test.aaa'          => 'AAA',
            'test.bbb'          => 'BBB',
            'test.ccc'          => 'CCC',
            'test.ddd'          => 'DDD',
            'Bar'               => 'Foo',
            'color'             => 'Color',
        ]);

        $this->right = Mockery::mock(DictionaryInterface::class);
        $this->right->shouldReceive('getFlattenDictionary')->andReturn([
            'Foo'                => 'Bar',
            'test.@TRANSLATION'  => 'Test',
            'test.aaa'           => 'AAA',
            'test.ccc'           => '',
            'test.bbb'           => 'BBB',
            'color.@TRANSLATION' => 'Color',
            'color.red'          => 'Red',
        ]);
    }

    public function testDictionaries(): void
    {
        // Compare flatten dictionaries
        // L -> R
        $this->assertSame([
            'test.ccc' => 'CCC',
            'test.ddd' => 'DDD',
            'Bar'      => 'Foo',
            'color'    => 'Color',
        ], Compare::dictionaries($this->left, $this->right));

        // R -> L
        $this->assertSame([
            'test.ccc'           => '',
            'color.@TRANSLATION' => 'Color',
            'color.red'          => 'Red',
        ], Compare::dictionaries($this->right, $this->left));

        // Compare direct dictionaries
        // L -> R
        $this->assertSame([
            'test' => [
                'ccc' => 'CCC',
                'ddd' => 'DDD',
            ],
            'Bar'   => 'Foo',
            'color' => 'Color',
        ], Compare::dictionaries($this->left, $this->right, true));

        // R -> L
        $this->assertSame([
            'test'     => [
                'ccc' => '',
            ],
            'color' => [
                '@TRANSLATION' => 'Color',
                'red'          => 'Red',
            ],
        ], Compare::dictionaries($this->right, $this->left, true));
    }

    public function testDictionariesKeys(): void
    {
        // L -> R
        $this->assertSame([
            'test.ddd',
            'Bar',
            'color',
        ], Compare::dictionariesKeys($this->left, $this->right));

        // R -> L
        $this->assertSame([
            'color.@TRANSLATION',
            'color.red',
        ], Compare::dictionariesKeys($this->right, $this->left));
    }

    public function testDictionariesValues(): void
    {
        // Compare flatten dictionaries
        // L -> R
        $this->assertSame([
            'Foo'               => 'Bar',
            'test.@TRANSLATION' => 'Test',
            'test.aaa'          => 'AAA',
            'test.bbb'          => 'BBB',
        ], Compare::dictionariesValues($this->left, $this->right));

        // R -> L
        $this->assertSame([
            'Foo'               => 'Bar',
            'test.@TRANSLATION' => 'Test',
            'test.aaa'          => 'AAA',
            'test.bbb'          => 'BBB',
        ], Compare::dictionariesValues($this->right, $this->left));

        // Compare direct dictionaries
        // L -> R
        $this->assertSame([
            'Foo'               => 'Bar',
            'test'              => [
                '@TRANSLATION' => 'Test',
                'aaa'          => 'AAA',
                'bbb'          => 'BBB',
            ],
        ], Compare::dictionariesValues($this->left, $this->right, true));

        // R -> L
        $this->assertSame([
            'Foo'               => 'Bar',
            'test'              => [
                '@TRANSLATION' => 'Test',
                'aaa'          => 'AAA',
                'bbb'          => 'BBB',
            ],
        ], Compare::dictionariesValues($this->right, $this->left, true));
    }

    public function testDictionariesEmptyValues(): void
    {
        // Left
        $this->assertSame([], Compare::dictionariesEmptyValues($this->left));

        // Right
        $this->assertSame(['test.ccc'], Compare::dictionariesEmptyValues($this->right));
    }
}
