<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Database;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use UserFrosting\Sprinkle\Core\Database\Factories\Factory;
use UserFrosting\Sprinkle\Core\Database\Models\Model;
use UserFrosting\Sprinkle\Core\Database\Models\Session;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase as TestCase;

/**
 * Generic test for factory abstract class.
 */
class FactoriesTest extends TestCase
{
    public function testFactory(): void
    {
        /** @var TestSession */
        $model = TestSession::factory()->make();
        $this->assertSame(serialize(['foo' => 'bar']), $model->payload);
    }
}

/**
 * Define stub factory for testing
 * @extends Factory<TestSession>
 */
class TestFactory extends Factory
{
    protected $model = TestSession::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payload'       => serialize(['foo' => 'bar']),
            'last_activity' => new DateTime('now'),
        ];
    }
}

class TestSession extends Session
{
    use HasFactory;

    /**
     * Create a new factory instance for the model.
     *
     * @return Factory<TestSession>
     */
    protected static function newFactory(): Factory
    {
        return TestFactory::new();
    }
}
