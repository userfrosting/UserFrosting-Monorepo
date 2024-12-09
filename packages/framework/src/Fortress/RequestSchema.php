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
use UserFrosting\Support\Repository\Loader\YamlFileLoader;
use UserFrosting\Support\Repository\Repository;

/**
 * Represents a schema for an HTTP request, compliant with the WDVSS standard
 * (https://github.com/alexweissman/wdvss).
 *
 * Same as \UserFrosting\Fortress\RequestSchema\RequestSchemaRepository, but
 * loads the schema from a file instead of an array.
 */
class RequestSchema extends Repository implements RequestSchemaInterface
{
    /**
     * Loads the request schema from a file.
     *
     * @param string|mixed[]|null $input Either the full path to the file containing the [WDVSS schema](https://github.com/alexweissman/wdvss),
     *                                   the schema itself, or null to load an empty schema.
     *
     * @throws \UserFrosting\Support\Exception\FileNotFoundException If $input is string, and the file does not exist.
     */
    public function __construct(string|array|null $input = null)
    {
        $items = match (true) {
            is_string($input) => (new YamlFileLoader($input))->load(false),
            is_array($input)  => $input,
            default           => [],
        };

        parent::__construct($items);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefault(string $field, string $value): static
    {
        if (!isset($this->items[$field])) {
            $this->items[$field] = [];
        }

        $this->items[$field]['default'] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addValidator(string $field, string $validatorName, array $parameters = []): static
    {
        if (!isset($this->items[$field])) {
            $this->items[$field] = [];
        }

        if (!isset($this->items[$field]['validators'])) {
            $this->items[$field]['validators'] = [];
        }

        $this->items[$field]['validators'][$validatorName] = $parameters;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeValidator(string $field, string $validatorName): static
    {
        unset($this->items[$field]['validators'][$validatorName]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTransformations(string $field, string|array $transformations = []): static
    {
        if (!is_array($transformations)) {
            $transformations = [$transformations];
        }

        if (!isset($this->items[$field])) {
            $this->items[$field] = [];
        }

        $this->items[$field]['transformations'] = $transformations;

        return $this;
    }
}
