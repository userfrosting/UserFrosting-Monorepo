<?php

/*
 * UserFrosting AdminLTE Theme (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/theme-adminlte
 * @copyright Copyright (c) 2021 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/theme-adminlte/blob/master/LICENSE (MIT License)
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
