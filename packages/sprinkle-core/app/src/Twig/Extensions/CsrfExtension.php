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
use Twig\Extension\GlobalsInterface;
use UserFrosting\Sprinkle\Core\Csrf\CsrfGuard;

class CsrfExtension extends AbstractExtension implements GlobalsInterface
{
    /**
     * @param CsrfGuard $csrf
     */
    public function __construct(
        protected CsrfGuard $csrf
    ) {
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals(): array
    {
        // CSRF token name and value
        $csrfNameKey = $this->csrf->getTokenNameKey();
        $csrfValueKey = $this->csrf->getTokenValueKey();
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenValue();

        return [
            'csrf'   => [
                'keys'  => [
                    'name'  => $csrfNameKey,
                    'value' => $csrfValueKey,
                ],
                'name'  => $csrfName,
                'value' => $csrfValue,
            ],
        ];
    }
}
