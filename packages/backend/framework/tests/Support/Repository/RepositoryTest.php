<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Support\Repository;

use PHPUnit\Framework\TestCase;
use UserFrosting\Support\Repository\Repository;

class RepositoryTest extends TestCase
{
    /** @var array<string,mixed> */
    protected array $data = [
        'voles' => [
            'caught'   => 8,
            'devoured' => null,
        ],
        'plumage'     => null,
        'chicks'      => 4,
        'in_flight'   => false,
        'name'        => '',
        'chick_names' => [],
    ];

    public function testGetDefined(): void
    {
        $repo = new Repository($this->data);

        $defined = $repo->getDefined();

        $this->assertEquals([
            'voles' => [
                'caught' => 8,
            ],
            'chicks'      => 4,
            'in_flight'   => false,
            'name'        => '',
            'chick_names' => [],
        ], $defined);
    }

    public function testGetDefinedSubkey(): void
    {
        $repo = new Repository($this->data);

        $defined = $repo->getDefined('voles');

        $this->assertEquals([
            'caught' => 8,
        ], $defined);
    }

    /**
     * @depends testGetDefined
     */
    public function testGetDefinedWithString(): void
    {
        $repo = new Repository($this->data);

        $defined = $repo->getDefined('chicks');

        $this->assertEquals(4, $defined);
    }

    /**
     * @depends testGetDefined
     */
    public function testGetDefinedWithArray(): void
    {
        $repo = new Repository($this->data);

        $defined = $repo->getDefined(['chicks', 'voles']);

        $this->assertEquals([
            'chicks' => 4,
            'voles'  => [
                'caught' => 8,
            ],
        ], $defined);
    }

    /**
     * @depends testGetDefinedWithString
     */
    public function testMergeItems(): void
    {
        $repo = new Repository($this->data);

        $repo->mergeItems('foo', 'bar');
        $defined = $repo->getDefined('foo');

        $this->assertEquals('bar', $defined);
    }

    /**
     * @depends testGetDefinedWithString
     */
    public function testMergeItemsWithArray(): void
    {
        $repo = new Repository($this->data);

        $newData = [
            'caught' => 4,
            'foo'    => 'bar',
        ];

        $repo->mergeItems('voles', $newData);
        $defined = $repo->getDefined('voles');

        $this->assertEquals($newData, $defined);
    }

    /**
     * @depends testGetDefinedWithString
     */
    public function testMergeItemsWithNull(): void
    {
        $repo = new Repository($this->data);

        $newData = [
            'foo'    => 'bar',
        ];

        $repo->mergeItems(null, $newData);
        $defined = $repo->getDefined('foo');

        $this->assertEquals('bar', $defined);
    }

    /**
     * @depends testMergeItems
     */
    public function testMergeItemsWithArrayAndNotArrayItems(): void
    {
        $repo = new Repository($this->data);

        $repo->mergeItems('voles', 'bar');
        $defined = $repo->getDefined('voles');

        $this->assertEquals('bar', $defined);
    }
}
