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
use UserFrosting\I18n\Translator;

/**
 * Loads validation rules from a schema and validates a target array of data.
 *
 * @deprecated 5.1 Use `\UserFrosting\Fortress\Validator\ServerSideValidatorInterface` instead.
 */
interface ServerSideValidatorInterface
{
    /**
     * Set the schema for this validator, as a valid RequestSchemaInterface object.
     *
     * @param RequestSchemaInterface $schema A RequestSchemaInterface object, containing the validation rules.
     */
    public function setSchema(RequestSchemaInterface $schema): void;

    /**
     * Set the translator for this validator, as a valid Translator object.
     *
     * @param Translator $translator A Translator to be used to translate message ids found in the schema.
     */
    public function setTranslator(Translator $translator): void;

    /**
     * Validate the specified data against the schema rules.
     *
     * @param mixed[] $data An array of data, mapping field names to field values.
     *
     * @return bool True if the data was successfully validated, false otherwise.
     */
    public function validate(array $data): bool;

    /**
     *  Get array of fields and data.
     *
     * @return mixed[]
     */
    public function data();

    /**
     * Get array of error messages.
     *
     * @return mixed[]|bool
     */
    public function errors();
}
