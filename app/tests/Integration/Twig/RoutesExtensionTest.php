<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Tests\Integration\Twig;

use Slim\Views\Twig;
use UserFrosting\Sprinkle\Core\Tests\CoreTestCase;

/**
 * Tests RoutesExtension.
 */
class RoutesExtensionTest extends CoreTestCase
{
    public function testUrlFor(): void
    {
        /** @var Twig */
        $view = $this->ci->get(Twig::class);

        $result = $view->fetchFromString("{{ urlFor('alerts') }}");
        $this->assertSame('/alerts', $result);
    }
}
