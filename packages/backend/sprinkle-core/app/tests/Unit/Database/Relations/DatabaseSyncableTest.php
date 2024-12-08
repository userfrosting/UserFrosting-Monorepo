<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Unit;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use stdClass;
use UserFrosting\Sprinkle\Core\Database\Builder;
use UserFrosting\Sprinkle\Core\Database\Relations\HasManySyncable;

/**
 * Tests the HasManySyncable relation.
 */
class DatabaseSyncableTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * @dataProvider syncMethodHasManyListProvider
     *
     * @param mixed[] $list
     */
    public function testSyncMethod(array $list): void
    {
        // Simulate fetching of current relationships (1,2,3)
        $query = Mockery::mock(stdClass::class);
        $query->shouldReceive('pluck')->once()->with('id')->andReturn(new Collection([1, 2, 3]));

        // Test deletions of items removed from relationship (1)
        $query->shouldReceive('whereIn')->once()->with('id', [1])->andReturn($query);
        $query->shouldReceive('delete')->once()->andReturn($query);

        // Test updates to existing items in relationship (2,3)
        $query->shouldReceive('where')->once()->with('id', 2)->andReturn($query);
        $query->shouldReceive('update')->once()->with(['id' => 2, 'species' => 'Tyto'])->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 3)->andReturn($query);
        $query->shouldReceive('update')->once()->with(['id' => 3, 'species' => 'Megascops'])->andReturn($query);

        // Set up and simulate base expectations for arguments to relationship.
        $related = Mockery::mock(Model::class);
        $related->shouldReceive('getKeyName')->once()->andReturn('id'); // Simulate determination of related key from builder
        $related->shouldReceive('withoutGlobalScopes')->times(3)->andReturn($query); // withoutGlobalScopes will get called exactly 3 times

        $builder = Mockery::mock(EloquentBuilder::class);
        $builder->shouldReceive('whereNotNull')->with('table.foreign_key')->once();
        $builder->shouldReceive('where')->with('table.foreign_key', '=', 1)->once();
        $builder->shouldReceive('getModel')->once()->andReturn($related);

        $parent = Mockery::mock(Model::class);
        $parent->shouldReceive('getAttribute')->with('id')->times(2)->andReturn(1);

        $relation = new HasManySyncable($builder, $parent, 'table.foreign_key', 'id');
        $relation->shouldReceive('newQuery')->once()->andReturn($query); // @phpstan-ignore-line

        // Test creation of new items ('x')
        $model = $this->expectCreatedModel($related, [
            'id' => 'x',
        ]);
        $model->shouldReceive('getAttribute')->with('id')->once()->andReturn('x');

        $this->assertEquals(['created' => ['x'], 'deleted' => [1], 'updated' => [2, 3]], $relation->sync($list));
    }

    /**
     * @dataProvider syncMethodHasManyListProvider
     *
     * @param mixed[] $list
     */
    public function testSyncMethodWithForceCreate(array $list): void
    {
        // Simulate fetching of current relationships (1,2,3)
        $query = Mockery::mock(stdClass::class);
        $query->shouldReceive('pluck')->once()->with('id')->andReturn(new Collection([1, 2, 3]));

        // Test deletions of items removed from relationship (1)
        $query->shouldReceive('whereIn')->once()->with('id', [1])->andReturn($query);
        $query->shouldReceive('delete')->once()->andReturn($query);

        // Test updates to existing items in relationship (2,3)
        $query->shouldReceive('where')->once()->with('id', 2)->andReturn($query);
        $query->shouldReceive('update')->once()->with(['id' => 2, 'species' => 'Tyto'])->andReturn($query);
        $query->shouldReceive('where')->once()->with('id', 3)->andReturn($query);
        $query->shouldReceive('update')->once()->with(['id' => 3, 'species' => 'Megascops'])->andReturn($query);

        // Set up and simulate base expectations for arguments to relationship.
        $related = Mockery::mock(Model::class);
        $related->shouldReceive('getKeyName')->once()->andReturn('id'); // Simulate determination of related key from builder
        $related->shouldReceive('withoutGlobalScopes')->times(3)->andReturn($query); // withoutGlobalScopes will get called exactly 3 times

        $builder = Mockery::mock(EloquentBuilder::class);
        $builder->shouldReceive('whereNotNull')->with('table.foreign_key')->once();
        $builder->shouldReceive('where')->with('table.foreign_key', '=', 1)->once();
        $builder->shouldReceive('getModel')->once()->andReturn($related);

        $parent = Mockery::mock(Model::class);
        $parent->shouldReceive('getAttribute')->with('id')->times(2)->andReturn(1);

        $relation = new HasManySyncable($builder, $parent, 'table.foreign_key', 'id');
        $relation->shouldReceive('newQuery')->once()->andReturn($query); // @phpstan-ignore-line

        // Test creation of new items ('x')
        $model = $this->expectForceCreatedModel($related, [
            'id'          => 'x',
            'foreign_key' => 1,
        ]);
        $model->shouldReceive('getAttribute')->with('id')->once()->andReturn('x');

        $this->assertEquals(['created' => ['x'], 'deleted' => [1], 'updated' => [2, 3]], $relation->sync($list, forceCreate: true));
    }

    /**
     * @return mixed[]
     **/
    public static function syncMethodHasManyListProvider(): array
    {
        return [
            // First test set
            [
                // First argument
                [
                    [
                        'id'      => 2,
                        'species' => 'Tyto',
                    ],
                    [
                        'id'      => 3,
                        'species' => 'Megascops',
                    ],
                    [
                        'id' => 'x',
                    ],
                ],
            ],
            // Additional test sets here
        ];
    }

    /**
     * @param Model&\Mockery\MockInterface $related
     * @param ?mixed[]                     $attributes
     *
     * @return Model&\Mockery\MockInterface
     */
    protected function expectNewModel(Model $related, ?array $attributes = null): Model
    {
        $related->shouldReceive('newInstance')
                ->with($attributes)
                ->once()
                ->andReturn($model = Mockery::mock(Model::class));

        $model->shouldReceive('setAttribute')->with('foreign_key', 1)->once()->andReturn($model);

        return $model;
    }

    /**
     * @param Model&\Mockery\MockInterface $relation
     * @param mixed[]                      $attributes
     *
     * @return Model&\Mockery\MockInterface
     */
    protected function expectCreatedModel(Model $relation, ?array $attributes): Model
    {
        $model = $this->expectNewModel($relation, $attributes);
        $model->shouldReceive('save')->once()->andReturn($model);

        return $model;
    }

    /**
     * @param Model&\Mockery\MockInterface $relation
     * @param mixed[]                      $attributes
     *
     * @return Model&\Mockery\MockInterface
     */
    protected function expectForceCreatedModel(Model $relation, ?array $attributes): Model
    {
        $relation->shouldReceive('forceCreate')
                ->with($attributes)
                ->once()
                ->andReturn($model = Mockery::mock(Model::class));

        return $model;
    }
}
