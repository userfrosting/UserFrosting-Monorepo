<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Fortress\Adapter;

use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;

/**
 * Loads validation rules from a schema and generates client-side rules
 * compatible with a particular client-side (usually Javascript) plugin.
 */
interface ValidationAdapterInterface
{
    /**
     * Generate and return the validation rules for specific validation adapter.
     * This method returns a collection of rules, in the format required by the specified plugin.
     *
     * @param RequestSchemaInterface $schema A RequestSchema object, containing the validation rules.
     *
     * @return mixed The validation rule collection.
     */
    public function rules(RequestSchemaInterface $schema): mixed;
}
