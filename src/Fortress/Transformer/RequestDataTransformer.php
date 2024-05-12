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

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Arr;
use UserFrosting\Fortress\FortressException;
use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;

/**
 * Perform a series of transformations on a set of data fields, as specified by
 * a RequestSchemaInterface.
 */
final class RequestDataTransformer implements RequestDataTransformerInterface
{
    /**
     * @var HTMLPurifier
     */
    protected HTMLPurifier $purifier;

    /**
     * Create a new data transformer.
     */
    public function __construct()
    {
        // Create purifier
        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.DefinitionImpl', null); // turn off cache
        $this->purifier = new HTMLPurifier($config);
    }

    /**
     * {@inheritdoc}
     */
    public function transform(
        RequestSchemaInterface $schema,
        array $data,
        string $onUnexpectedVar = 'skip'
    ): array {
        // Get schema fields
        $schemaFields = $schema->all();

        // 1. If we skip or error on unexpected var, purge unwanted fields
        if ($onUnexpectedVar === 'skip' || $onUnexpectedVar === 'error') {
            $data = $this->purge($schemaFields, $data, ($onUnexpectedVar === 'error'));
        }

        // 2° Apply each transformation rules. Skip we field as no transformation rules
        foreach ($schemaFields as $field => $rules) {
            if (!isset($rules['transformations']) || !is_array($rules['transformations'])) {
                continue;
            }

            $data = $this->applyNestedTransformation($rules['transformations'], explode('.', $field), $data);
        }

        // 3. Get default values for any fields missing from $data. Especially
        //    useful for checkboxes, etc which are not submitted when they are
        //    unchecked
        foreach ($schemaFields as $fieldName => $field) {
            if (!isset($data[$fieldName]) && isset($field['default'])) {
                $data[$fieldName] = $field['default'];
            }
        }

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function transformField(RequestSchemaInterface $schema, string $name, mixed $value): mixed
    {
        $schemaFields = $schema->all();

        // Return value if field is not in schema
        if (!array_key_exists($name, $schemaFields)) {
            return $value;
        }

        $fieldParameters = $schemaFields[$name];

        if (!isset($fieldParameters['transformations']) || !is_array($fieldParameters['transformations'])) {
            return $value;
        } else {
            // Field exists in schema, so apply sequence of transformations
            return $this->applyTransformation($fieldParameters['transformations'], $value);
        }
    }

    /**
     * Apply transformations to a set of nested keys.
     *
     * @param string[] $rules Rules to apply
     * @param string[] $keys  Nested keys. Dot notation keys (eg. 'foo.bar')
     *                        represented as an array (eg. array('foo', 'bar'))
     * @param mixed    $data  The data to transform
     *
     * @return mixed The transformed data
     */
    protected function applyNestedTransformation(array $rules, array $keys, mixed $data): mixed
    {
        $key = array_shift($keys);

        // Parse each element in non-associative array
        if ($key === '*' && is_array($data)) {
            foreach ($data as $id => $row) {
                $data[$id] = $this->applyNestedTransformation($rules, $keys, $row);
            }

            return $data;
        }

        // Reached the deepest level. Transform the data directly.
        if ($key === null) {
            return $this->applyTransformation($rules, $data);
        }

        // If data don't exist for this key, can't transform what doesn't exist.
        if (!isset($data[$key])) {
            return $data;
        }

        // Reached last key, and data exist, apply transformation to the key.
        if (count($keys) === 0) {
            $data[$key] = $this->applyTransformation($rules, $data[$key]);

            return $data;
        }

        // Dig down another level.
        $data[$key] = $this->applyNestedTransformation($rules, $keys, $data[$key]);

        return $data;
    }

    /**
     * Apply rules to a set of values.
     *
     * @param string[] $rules The rules to apply
     * @param mixed    $value The value to transform
     *
     * @return mixed The transformed value
     */
    protected function applyTransformation(array $rules, mixed $value): mixed
    {
        foreach ($rules as $transformation) {
            $value = match (strtolower($transformation)) {
                'purify' => $this->purify($value),
                'escape' => $this->escapeHtmlCharacters($value),
                'purge'  => $this->purgeHtmlCharacters($value),
                'trim'   => $this->trim($value),
                default  => $value,
            };
        }

        return $value;
    }

    /**
     * Purge all fields not present the schema fields list.
     *
     * @param array<string, mixed[]> $schemaFields The fields from the schema to keep.
     * @param mixed[]                $data         The data to purge
     * @param bool                   $throw        If true, a FortressException will be thrown if something to purge is found
     *
     * @throws FortressException If $throw is true and we found something to purge
     * @return mixed[]           The purged data
     */
    protected function purge(array $schemaFields, array $data, bool $throw = false): array
    {
        // N.B.: The '*' wildcard in the schema fields makes it difficult to
        // fetch everything we need to keep. Instead, we use double negation :
        // It's easier to remove the one we want to keep, then compare this list
        // with the original. Plus It will allow to throw exception with the
        // extra field.

        // First, we remove all rules, as we don't need them and don't want to
        // dot the nested rules.
        $fields = array_flip(array_keys($schemaFields));

        // Then, we need to remove duplicate and overlaps. For example, `Foo.*`
        // and `Foo` overlaps.
        $fields = Arr::dot(Arr::undot($fields));

        // Next, find all data that need to be purged.
        $toPurge = $data;
        foreach ($fields as $field => $rules) {
            $toPurge = $this->purgeParts(explode('.', $field), $toPurge);
        }

        // Throw exception if we have fields to purge and onUnexpectedVar
        // is set to error, continue otherwise (if it's skip)
        if ($throw && count($toPurge) > 0) {
            $fields = implode(', ', array_keys(Arr::dot($toPurge)));

            throw new FortressException("The fields '$fields' are not a valid input field.");
        }

        // Finally we loop again using the same method to apply the purge
        // with the converted '*' wildcard to the original data. However,
        // this time we use the field to purge instead of the schema data.
        $dotToForget = Arr::dot($toPurge);
        foreach ($dotToForget as $field => $value) {
            $data = $this->purgeParts(explode('.', $field), $data);
        }

        return $data;
    }

    /**
     * Purge a set of nested keys.
     *
     * @param string[] $keys Nested keys. Dot notation keys (eg. 'foo.bar')
     *                        represented as an array (eg. array('foo', 'bar'))
     * @param mixed[]  $data  The data to purge from
     *
     * @return mixed[] The purged data
     */
    protected function purgeParts(array $keys, array $data): array
    {
        $key = array_shift($keys);

        // Parse each element in non-associative array
        if ($key === '*') {
            foreach ($data as $id => $row) {
                // Do we need to do another level deeper?
                if (is_array($row)) {
                    $data[$id] = $this->purgeParts($keys, $row);

                    // Delete empty array
                    if (count($data[$id]) === 0) {
                        unset($data[$id]);
                    }
                } else {
                    unset($data[$id]);
                }
            }

            return $data;
        }

        // If data don't exist for this key, can't transform what doesn't exist.
        if ($key === null || !isset($data[$key])) {
            return $data;
        }

        // Reached the last key, and data exist, remove it.
        if (count($keys) === 0) {
            unset($data[$key]);

            return $data;
        }

        // Last resort, we dig into another level
        $data[$key] = $this->purgeParts($keys, $data[$key]);
        if (count($data[$key]) === 0) {
            unset($data[$key]);
        }

        return $data;
    }

    /**
     * Autodetect if a field is an array or scalar, and filter appropriately.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function escapeHtmlCharacters(mixed $value): mixed
    {
        if (is_array($value)) {
            return filter_var_array($value, FILTER_SANITIZE_SPECIAL_CHARS); // @phpstan-ignore-line
        }

        return filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS); // @phpstan-ignore-line
    }

    /**
     * Autodetect if a field is an array or scalar, and filter appropriately.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function purgeHtmlCharacters(mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->arrayMapRecursive('strip_tags', $value);
        }

        // Nothing to purge if it's not a string
        if (!is_string($value)) {
            return $value;
        }

        return strip_tags($value);
    }

    /**
     * Autodetect if a field is an array or scalar, and filter appropriately.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function trim(mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->arrayMapRecursive('trim', $value);
        }

        // Nothing to purge if it's not a string
        if (!is_string($value)) {
            return $value;
        }

        return trim($value);
    }

    /**
     * Autodetect if a field is an array or scalar, and filter appropriately.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function purify(mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->arrayMapRecursive([$this->purifier, 'purify'], $value);
        }

        // Nothing to purge if it's not a string
        if (!is_string($value)) {
            return $value;
        }

        return $this->purifier->purify($value);
    }

    /**
     * Applies the callback to the elements of the given arrays recursively.
     * Required to apply transformation on multidimensional arrays.
     * @see https://stackoverflow.com/a/39637749/445757
     *
     * @param callable $callback
     * @param mixed[]  $array
     *
     * @return mixed[]
     */
    protected function arrayMapRecursive(callable $callback, array $array): array
    {
        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };

        return array_map($func, $array);
    }
}
