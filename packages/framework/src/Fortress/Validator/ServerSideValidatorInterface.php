<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Fortress\Validator;

use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;

/**
 * Loads validation rules from a schema and validates a target array of data.
 */
interface ServerSideValidatorInterface
{
    /**
     * Validate the specified data against the schema rules.
     *
     * @param RequestSchemaInterface $schema A RequestSchemaInterface object, containing the validation rules.
     * @param mixed[]                $data   An array of data to validate, mapping field names to field values.
     *
     * @return mixed[] The array of errors, mapping {field_names => errors[]}. Empty array if no errors.
     */
    public function validate(RequestSchemaInterface $schema, array $data): array;
}
