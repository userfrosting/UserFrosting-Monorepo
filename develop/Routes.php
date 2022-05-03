<?php

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Develop\Admin;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;
use Slim\Views\Twig;
use UserFrosting\Routes\RouteDefinitionInterface;

class Routes implements RouteDefinitionInterface
{
    public function register(App $app): void
    {
        $app->get('/', function (Response $response, Twig $view) {
            return $view->render($response, 'pages/index.html.twig');
        })->setName('index');
    }
}
