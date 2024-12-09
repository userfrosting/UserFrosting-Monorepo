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
use UserFrosting\I18n\Translator;

/**
 * Loads validation rules from a schema and generates client-side rules
 * compatible with the jQuery Validation (http://http://jqueryvalidation.org)
 * JS plugin.
 *
 * @deprecated Since 5.1 Instead use :
 *  - json, $stringEncode = true : JqueryValidationJsonAdapter
 *  - json, $stringEncode = false : JqueryValidationArrayAdapter
 */
class JqueryValidationAdapter
{
    /**
     * @param RequestSchemaInterface $schema     A RequestSchema object, containing the validation rules.
     * @param Translator             $translator A Translator to be used to translate message ids found in the schema.
     */
    public function __construct(
        protected RequestSchemaInterface $schema,
        protected Translator $translator
    ) {
    }

    /**
     * Set the schema for this validator.
     *
     * @param RequestSchemaInterface $schema A RequestSchemaInterface object, containing the validation rules.
     *
     * @return $this
     */
    public function setSchema(RequestSchemaInterface $schema): static
    {
        $this->schema = $schema;

        return $this;
    }

    /**
     * Set the translator for this validator, as a valid MessageTranslator object.
     *
     * @param Translator $translator A Translator to be used to translate message ids found in the schema.
     *
     * @return $this
     */
    public function setTranslator(Translator $translator): static
    {
        $this->translator = $translator;

        return $this;
    }

    /**
     * Generate jQuery Validation compatible rules from the specified
     * RequestSchema, as a JSON document. See url below as an example of what
     * this function will generate.
     *
     * @see https://github.com/jzaefferer/jquery-validation/blob/master/demo/bootstrap/index.html#L168-L209
     *
     * @param string $format       (Default: json)
     * @param bool   $stringEncode Specify whether to return a PHP array, or a JSON-encoded string. (default: false)
     * @param string $arrayPrefix  (Default: '')
     *
     * @return string|mixed[] Returns either the array of rules, or a JSON-encoded representation of that array.
     */
    public function rules(string $format = 'json', bool $stringEncode = false, string $arrayPrefix = ''): string|array
    {
        return match ($stringEncode) {
            true  => (new JqueryValidationJsonAdapter($this->translator))->rules($this->schema, $arrayPrefix),
            false => (new JqueryValidationArrayAdapter($this->translator))->rules($this->schema, $arrayPrefix),
        };
    }
}
