<?php

declare(strict_types=1);

/*
 * UserFrosting Admin Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-admin
 * @copyright Copyright (c) 2013-2024 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-admin/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Admin\Controller\Dashboard;

use Carbon\Carbon;
use Illuminate\Database\Connection;
use PDO;
use PDOException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use UserFrosting\Config\Config;
use UserFrosting\Sprinkle\Account\Authenticate\Authenticator;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\GroupInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\RoleInterface;
use UserFrosting\Sprinkle\Account\Database\Models\Interfaces\UserInterface;
use UserFrosting\Sprinkle\Account\Exceptions\ForbiddenException;
use UserFrosting\Sprinkle\SprinkleManager;
use UserFrosting\UniformResourceLocator\ResourceLocatorInterface;

/**
 * Api for /dashboard URL. Handles admin-related activities.
 */
class DashboardAction
{
    /**
     * Inject dependencies.
     */
    public function __construct(
        protected Authenticator $authenticator,
        protected Config $config,
        protected Connection $dbConnection,
        protected SprinkleManager $sprinkleManager,
        protected ResourceLocatorInterface $locator,
        protected UserInterface $userModel,
        protected RoleInterface $roleModel,
        protected GroupInterface $groupModel,
    ) {
    }

    /**
     * Receive the request, dispatch to the handler, and return the payload to
     * the response.
     *
     * @param Request  $request
     * @param Response $response
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $this->validateAccess();
        $payload = $this->handle($request);

        // Write json response
        $payload = json_encode($payload, JSON_THROW_ON_ERROR);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Validate access to the page.
     *
     * @throws ForbiddenException
     */
    protected function validateAccess(): void
    {
        if (!$this->authenticator->checkAccess('uri_dashboard')) {
            throw new ForbiddenException();
        }
    }

    /**
     * Handle the request and return the payload.
     *
     * @param Request $request
     *
     * @return mixed[]
     */
    protected function handle(Request $request): array
    {
        return [
            'counter'   => [
                'users'  => $this->userModel::count(),
                'roles'  => $this->roleModel::count(),
                'groups' => $this->groupModel::count(),
            ],
            'info'      => [
                'version'     => [
                    'framework' => (string) \Composer\InstalledVersions::getPrettyVersion('userfrosting/framework'),
                    'php'       => phpversion(),
                ],
                'database'    => $this->getDatabaseInfo(),
                'environment' => $_SERVER,
                'path'        => [
                    'project' => $this->locator->getBasePath(),
                ],
            ],
            'sprinkles' => $this->sprinkleManager->getSprinklesNames(),
            'users'     => $this->getLatestUsers(),
        ];
    }

    /**
     * Get the latest users.
     *
     * @return UserInterface[]
     */
    protected function getLatestUsers(): array
    {
        // Probably a better way to do this
        $users = $this->userModel::orderBy('created_at', 'desc')
                 ->take(8)
                 ->get();

        // Transform the `create_at` date in "x days ago" type of string
        $users->transform(function ($item, $key) {
            $item->registered = Carbon::parse($item->created_at)->diffForHumans();

            return $item;
        });

        return $users->toArray();
    }

    /**
     * Returns database information.
     *
     * @return array{connection: string, name: string, type: string, version: string}
     */
    protected function getDatabaseInfo(): array
    {
        $database = $this->config->getString('db.default', '');
        $pdo = $this->dbConnection->getPdo();
        $results = [
            'connection' => $database,
            'name'       => $this->dbConnection->getDatabaseName(),
        ];

        try {
            $results['type'] = strval($pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
        } catch (PDOException $e) {
            $results['type'] = 'Unknown';
        }

        try {
            $results['version'] = strval($pdo->getAttribute(PDO::ATTR_SERVER_VERSION));
        } catch (PDOException $e) {
            $results['version'] = '';
        }

        return $results;
    }
}
