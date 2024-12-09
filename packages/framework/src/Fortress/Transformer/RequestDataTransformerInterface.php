<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Fortress\Transformer;

use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;

/**
 * Perform a series of transformations on a set of data fields, as specified by
 * a RequestSchemaInterface.
 */
interface RequestDataTransformerInterface
{
    /**
     * Process each field in the specified data array, applying transformations in the specified order.
     *
     * Example transformations: escape/purge/purify HTML entities
     * Also, set any default values for unspecified fields.
     *
     * @param mixed[] $data            The array of data to be transformed.
     * @param string  $onUnexpectedVar (Optional) Determines what to do when a field is encountered that is not in the schema. Set to one of:
     *                                 - "allow": Treat the field as any other, allowing the value through.
     *                                 - "error": Raise an exception.
     *                                 - "skip" (default): Quietly ignore the field. It will not be part of the transformed data array.
     *
     * @return mixed[] The array of transformed data, mapping field names => values.
     */
    public function transform(RequestSchemaInterface $schema, array $data, string $onUnexpectedVar = 'skip'): array;

    /**
     * Transform a raw field value.
     *
     * @param string $name  The name of the field to transform, as specified in the schema.
     * @param mixed  $value The value to be transformed.
     *
     * @return mixed The transformed value.
     */
    public function transformField(RequestSchemaInterface $schema, string $name, mixed $value): mixed;
}
