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
 * compatible with the FormValidation (http://formvalidation.io) JS plugin.
 *
 * @deprecated Since 5.1 Instead use :
 *  - json, $stringEncode = true : FormValidationJsonAdapter
 *  - json, $stringEncode = false : FormValidationArrayAdapter
 *  - html5 : FormValidationHtml5Adapter
 */
class FormValidationAdapter
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
     * @return mixed[]|string
     */
    public function rules(string $format = 'json', bool $stringEncode = true): array|string
    {
        return match (true) {
            ($format === 'html5')                  => (new FormValidationHtml5Adapter())->rules($this->schema),
            ($format === 'json' && !$stringEncode) => (new FormValidationArrayAdapter($this->translator))->rules($this->schema),
            default                                => (new FormValidationJsonAdapter($this->translator))->rules($this->schema),
        };
    }
}
