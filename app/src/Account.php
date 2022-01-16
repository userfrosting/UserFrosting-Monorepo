<?php

/*
 * UserFrosting Account Sprinkle (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/sprinkle-account
 * @copyright Copyright (c) 2022 Alexander Weissman & Louis Charette
 * @license   https://github.com/userfrosting/sprinkle-account/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\Account;

use UserFrosting\Sprinkle\Account\Bakery\BakeCommand;
use UserFrosting\Sprinkle\Account\Bakery\CreateAdminUser;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\ActivitiesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\GroupsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PasswordResetsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionRolesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PermissionsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\PersistencesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\RolesTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\RoleUsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\UsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v400\VerificationsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v420\AddingForeignKeys;
use UserFrosting\Sprinkle\Account\Database\Migrations\v430\UpdateGroupsTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v430\UpdateUsersTable;
use UserFrosting\Sprinkle\Account\Database\Migrations\v500\UpdateUsersTable as V500UpdateUsersTable;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultGroups;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultPermissions;
use UserFrosting\Sprinkle\Account\Database\Seeds\DefaultRoles;
use UserFrosting\Sprinkle\Account\I18n\LocaleServicesProvider;
use UserFrosting\Sprinkle\Account\Routes\AuthRoutes;
use UserFrosting\Sprinkle\Core\Core;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\MigrationRecipe;
use UserFrosting\Sprinkle\Core\Sprinkle\Recipe\SeedRecipe;
use UserFrosting\Sprinkle\SprinkleRecipe;

class Account implements SprinkleRecipe, MigrationRecipe, SeedRecipe
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Account Sprinkle';
    }

    /**
     * {@inheritdoc}
     */
    public function getPath(): string
    {
        return __DIR__ . '/../';
    }

    /**
     * {@inheritdoc}
     */
    public function getBakeryCommands(): array
    {
        return [
            // BakeCommand::class,
            // CreateAdminUser::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSprinkles(): array
    {
        return [
            Core::class,
        ];
    }

    /**
     * Returns a list of routes definition in PHP files.
     *
     * @return string[]
     */
    public function getRoutes(): array
    {
        return [
            AuthRoutes::class,
        ];
    }

    /**
     * Returns a list of all PHP-DI services/container definitions files.
     *
     * @return string[]
     */
    public function getServices(): array
    {
        return [
            // LocaleServicesProvider::class, // TODO
        ];
    }

    /**
     * Returns a list of all Middlewares classes.
     *
     * @return \Psr\Http\Server\MiddlewareInterface[]
     */
    public function getMiddlewares(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getMigrations(): array
    {
        return [
            // v400
            ActivitiesTable::class,
            GroupsTable::class,
            PasswordResetsTable::class,
            PermissionRolesTable::class,
            RolesTable::class,
            PermissionsTable::class,
            PersistencesTable::class,
            RoleUsersTable::class,
            UsersTable::class,
            // v420
            VerificationsTable::class,
            AddingForeignKeys::class,
            // v430
            UpdateGroupsTable::class,
            UpdateUsersTable::class,
            // v500
            V500UpdateUsersTable::class,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getSeeds(): array
    {
        return [
            DefaultGroups::class,
            DefaultPermissions::class,
            DefaultRoles::class,
        ];
    }
}
