<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\I18n;

use Illuminate\Contracts\Config\Repository;

/**
 * Used to return all "Key => translation" data matrix
 * Extend the Config repository to have access to all the standard `has`, `get`,
 * etc. public methods on the dictionary array.
 */
interface DictionaryInterface extends Repository
{
    /**
     * Returns all loaded locale Key => Translation data dictionary.
     *
     * @return mixed[] The locale dictionary
     */
    public function getDictionary(): array;

    /**
     * Return the associate locale.
     *
     * @return LocaleInterface
     */
    public function getLocale(): LocaleInterface;

    /**
     * Return the dictionary as a flatten array, using dot notation.
     *
     * @return string[]
     */
    public function getFlattenDictionary(): array;
}
