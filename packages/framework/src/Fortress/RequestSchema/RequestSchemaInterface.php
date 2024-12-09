<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Fortress\RequestSchema;

use Illuminate\Contracts\Config\Repository as ConfigContract;

/**
 * Represents a schema for an HTTP request, compliant with the WDVSS standard
 * (https://github.com/alexweissman/wdvss).
 */
interface RequestSchemaInterface extends ConfigContract
{
    /**
     * Get all items in the schema.
     *
     * @return array<string, mixed[]>
     */
    public function all();

    /**
     * Recursively merge values (scalar or array) into this repository.
     *
     * If no key is specified, the items will be merged in starting from the top level of the array.
     * If a key IS specified, items will be merged into that key.
     * Nested keys may be specified using dot syntax.
     *
     * @param string|null $key
     * @param mixed       $items
     *
     * @return static
     */
    public function mergeItems(?string $key, mixed $items): static;

    /**
     * Set the default value for a specified field.
     *
     * If the specified field does not exist in the schema, add it.  If a default already exists for this field, replace it with the value specified here.
     *
     * @param string $field The name of the field (e.g., "user_name")
     * @param string $value The new default value for this field.
     *
     * @return static This schema object.
     */
    public function setDefault(string $field, string $value): static;

    /**
     * Adds a new validator for a specified field.
     *
     * If the specified field does not exist in the schema, add it.  If a validator with the specified name already exists for the field,
     * replace it with the parameters specified here.
     *
     * @param string               $field         The name of the field for this validator (e.g., "user_name")
     * @param string               $validatorName A validator rule, as specified in https://github.com/alexweissman/wdvss (e.g. "length")
     * @param array<string, mixed> $parameters    An array of parameters, hashed as parameter_name => parameter value (e.g. [ "min" => 50 ])
     *
     * @return static This schema object.
     */
    public function addValidator(string $field, string $validatorName, array $parameters = []): static;

    /**
     * Remove a validator for a specified field.
     *
     * @param string $field         The name of the field for this validator (e.g., "user_name")
     * @param string $validatorName A validator rule, as specified in https://github.com/alexweissman/wdvss (e.g. "length")
     *
     * @return static This schema object.
     */
    public function removeValidator(string $field, string $validatorName): static;

    /**
     * Set a sequence of transformations for a specified field.
     *
     * If the specified field does not exist in the schema, add it.
     *
     * @param string          $field           The name of the field for this transformation (e.g., "user_name")
     * @param string|string[] $transformations An array of transformations, as specified in https://github.com/alexweissman/wdvss (e.g. "purge")
     *
     * @return static This schema object.
     */
    public function setTransformations(string $field, string|array $transformations = []): static;
}
