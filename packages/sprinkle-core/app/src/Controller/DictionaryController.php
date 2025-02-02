<?php

/*
 * UserFrosting Core Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-core
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-core/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Core\Controller;

use Illuminate\Cache\Repository as Cache;
use Psr\Http\Message\ResponseInterface as Response;
use UserFrosting\I18n\DictionaryInterface;

/**
 * Return the translator dictionary to use in the frontend.
 *
 * Middleware: none
 * Route: /api/dictionary
 * Route Name: api.dictionary
 * Request type: GET
 */
class DictionaryController
{
    /**
     * @param DictionaryInterface $dictionary
     * @param Cache               $cache
     */
    public function __construct(
        protected DictionaryInterface $dictionary,
        protected Cache $cache,
    ) {
    }

    /**
     * @param Response $response
     *
     * @return Response
     */
    public function __invoke(Response $response): Response
    {
        $payload = json_encode($this->getDictionaryData(), JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);

        return $response
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * Return the dictionary and locale info as an array to use in the frontend.
     * The dictionary is cached by identifier to avoid re-generating it on each
     * request.
     *
     * @return array{
     *     "identifier": string,
     *     "config": string[],
     *     "dictionary": string[]
     * }
     */
    public function getDictionaryData(): array
    {
        // Use the current locale as cache identifier
        $identifier = $this->dictionary->getLocale()->getIdentifier();

        return $this->cache->rememberForever('dictionary.' . $identifier, function () {
            return [
                'identifier' => $this->dictionary->getLocale()->getIdentifier(),
                'config'     => $this->dictionary->getLocale()->getConfig(),
                'dictionary' => $this->dictionary->getFlattenDictionary(),
            ];
        });
    }
}
