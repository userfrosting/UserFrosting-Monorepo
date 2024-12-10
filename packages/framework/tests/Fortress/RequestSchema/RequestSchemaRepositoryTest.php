<?php

declare(strict_types=1);

/*
 * UserFrosting Framework (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/framework
 * @copyright Copyright (c) 2013-2024 Alexander Weissman, Louis Charette, Jordan Mele
 * @license   https://github.com/userfrosting/framework/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Tests\Fortress\RequestSchema;

use PHPUnit\Framework\TestCase;
use UserFrosting\Fortress\RequestSchema\RequestSchemaRepository;
use UserFrosting\Support\Repository\Loader\YamlFileLoader;

/**
 * @deprecated 5.1 Keeping this to test the wrapper is functional
 */
class RequestSchemaRepositoryTest extends TestCase
{
    public function testRequestSchemaRepository(): void
    {
        $loader = new YamlFileLoader(__DIR__ . '/../data/contact.json');
        $schema = new RequestSchemaRepository($loader->load());
        $contactSchema = [
            'message' => [
                'validators' => [
                    'required' => [
                        'message' => 'Please enter a message',
                    ],
                ],
            ],
        ];
        $this->assertSame($contactSchema['message'], $schema->all()['message']);
    }
}
