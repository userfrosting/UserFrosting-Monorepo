<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory as LaravelFactory;

/**
 * Adapt Laravel Factory abstract class for use with UserFrosting.
 *
 * @template TModel of \Illuminate\Database\Eloquent\Model
 *
 * @extends LaravelFactory<TModel>
 */
abstract class Factory extends LaravelFactory
{
    protected function withFaker()
    {
        return FakerFactory::create();
    }
}
