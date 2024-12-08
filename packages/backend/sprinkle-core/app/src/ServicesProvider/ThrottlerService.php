<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\ServicesProvider;

use UserFrosting\Config\Config;
use UserFrosting\ServicesProvider\ServicesProviderInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Interfaces\ThrottleModelInterface;
use UserFrosting\Sprinkle\Core\Database\Models\Throttle;
use UserFrosting\Sprinkle\Core\Throttle\Throttler;
use UserFrosting\Sprinkle\Core\Throttle\ThrottleRule;

/**
 * Request throttler.
 *
 * Throttles (rate-limits) requests of a predefined type, with rules defined in site config.
 */
class ThrottlerService implements ServicesProviderInterface
{
    public function register(): array
    {
        return [
            Throttler::class               => function (ThrottleModelInterface $model, Config $config) {
                $throttler = new Throttler($model);

                if ($config->has('throttles') && is_array($config->get('throttles'))) {
                    foreach ($config->get('throttles') as $type => $rule) {
                        if ($rule) {
                            $throttleRule = new ThrottleRule($rule['method'], $rule['interval'], $rule['delays']);
                            $throttler->addThrottleRule($type, $throttleRule);
                        } else {
                            $throttler->addThrottleRule($type, null);
                        }
                    }
                }

                return $throttler;
            },

            // Map Throttle Model
            ThrottleModelInterface::class  => \DI\autowire(Throttle::class),
        ];
    }
}
