<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Fortress;

use UserFrosting\Fortress\RequestSchema\RequestSchemaInterface;
use UserFrosting\Fortress\Transformer\RequestDataTransformer as DataTransformer;

/**
 * Perform a series of transformations on a set of data fields, as specified by
 * a RequestSchemaInterface.
 *
 * @deprecated 5.1 Use `\UserFrosting\Fortress\Transformer\RequestDataTransformer` instead
 */
class RequestDataTransformer implements RequestDataTransformerInterface
{
    protected DataTransformer $transformer;

    /**
     * Create a new data transformer.
     *
     * @param RequestSchemaInterface $schema A RequestSchemaInterface object, containing the transformation rules.
     */
    public function __construct(protected RequestSchemaInterface $schema)
    {
        $this->transformer = new DataTransformer();
    }

    /**
     * Set the schema for this transformer, as a valid RequestSchemaInterface object.
     *
     * @param RequestSchemaInterface $schema A RequestSchemaInterface object, containing the transformation rules.
     *
     * @return $this
     */
    public function setSchema(RequestSchemaInterface $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function transform(array $data, string $onUnexpectedVar = 'skip'): array
    {
        return $this->transformer->transform($this->schema, $data, $onUnexpectedVar);
    }

    /**
     * {@inheritdoc}
     */
    public function transformField(string $name, array|string $value): array|string
    {
        return $this->transformer->transformField($this->schema, $name, $value);
    }
}
