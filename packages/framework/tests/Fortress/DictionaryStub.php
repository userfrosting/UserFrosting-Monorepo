<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress;

use UserFrosting\I18n\DictionaryInterface;
use UserFrosting\I18n\Locale;
use UserFrosting\I18n\LocaleInterface;
use UserFrosting\Support\Repository\Repository;

class DictionaryStub extends Repository implements DictionaryInterface
{
    // @phpstan-ignore-next-line
    public function __construct()
    {
    }

    public function getDictionary(): array
    {
        return [];
    }

    public function getLocale(): LocaleInterface
    {
        return new Locale('en_US');
    }

    public function getFlattenDictionary(): array
    {
        return [];
    }
}
