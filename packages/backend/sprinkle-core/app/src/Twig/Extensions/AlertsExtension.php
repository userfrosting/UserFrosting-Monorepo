<?php

declare(strict_types=1);

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use UserFrosting\Alert\AlertStream;

class AlertsExtension extends AbstractExtension
{
    /**
     * @param AlertStream $alertStream
     */
    public function __construct(protected AlertStream $alertStream)
    {
    }

    /**
     * Adds Twig functions `getAlerts`.
     *
     * @return TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('getAlerts', [$this, 'getAlerts']),
        ];
    }

    /**
     * Get the current alerts and optionally clear them.
     *
     * @param bool $clear Clear
     *
     * @return array<int, array{type: string, message: string, placeholders: mixed[]|int}> Messages to display
     */
    public function getAlerts(bool $clear = true): array
    {
        if ($clear) {
            return $this->alertStream->getAndClearMessages();
        } else {
            return $this->alertStream->messages();
        }
    }
}
