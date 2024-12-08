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
 * Returns the rules as a JSON encoded string.
 */
final class FormValidationJsonAdapter implements ValidationAdapterInterface
{
    /**
     * @param Translator $translator A Translator to be used to translate message ids found in the schema.
     */
    public function __construct(protected Translator $translator)
    {
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function rules(RequestSchemaInterface $schema): string
    {
        $arrayAdapter = new FormValidationArrayAdapter($this->translator);

        return json_encode($arrayAdapter->rules($schema), JSON_PRETTY_PRINT | JSON_FORCE_OBJECT | JSON_THROW_ON_ERROR);
    }
}
