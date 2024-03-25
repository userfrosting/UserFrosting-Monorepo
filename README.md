# UserFrosting 5.2 Admin Sprinkle

[![Version](https://img.shields.io/github/v/release/userfrosting/sprinkle-admin?include_prereleases)](https://github.com/userfrosting/sprinkle-admin/releases)
![PHP Version](https://img.shields.io/badge/php-%5E8.1-brightgreen)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-admin/Build.yml?branch=5.2&logo=github)](https://github.com/userfrosting/sprinkle-admin/actions)
[![Codecov](https://codecov.io/gh/userfrosting/sprinkle-admin/branch/5.2/graph/badge.svg)](https://app.codecov.io/gh/userfrosting/sprinkle-admin/branch/5.2)
[![StyleCI](https://github.styleci.io/repos/487673317/shield?branch=5.2&style=flat)](https://github.styleci.io/repos/487673317)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-admin/PHPStan.yml?branch=5.2&label=PHPStan)](https://github.com/userfrosting/sprinkle-admin/actions/workflows/PHPStan.yml)
[![Join the chat](https://img.shields.io/badge/Chat-UserFrosting-brightgreen?logo=Rocket.Chat)](https://chat.userfrosting.com)
[![Donate](https://img.shields.io/badge/Open_Collective-Donate-blue?logo=Open%20Collective)](https://opencollective.com/userfrosting#backer)
[![Donate](https://img.shields.io/badge/Ko--fi-Donate-blue?logo=ko-fi&logoColor=white)](https://ko-fi.com/lcharette)

## By [Alex Weissman](https://alexanderweissman.com) and [Louis Charette](https://bbqsoftwares.com)

Copyright (c) 2013-2024, free to use in personal and commercial software as per the [license](LICENSE.md).

UserFrosting is a secure, modern user management system written in PHP and built on top of the [Slim Microframework](http://www.slimframework.com/), [Twig](http://twig.sensiolabs.org/) templating engine, and [Eloquent](https://laravel.com/docs/5.8/eloquent#introduction) ORM.

This **Admin sprinkle** contains the routes and controllers to implement the administrative user management interface, as well as the group, role, and permission management interfaces.

## Installation
1. Require in your [UserFrosting](https://github.com/userfrosting/UserFrosting) project : 
    ``` 
    composer require userfrosting/sprinkle-admin
    ```

2. Add the Sprinkle to your Sprinkle Recipe : 
    ```php
    public function getSprinkles(): array
    {
        return [
            \UserFrosting\Sprinkle\Admin\Admin::class,
        ];
    }
    ```

3. Bake
    ```bash
    php bakery bake
    ```

## Documentation
See main [UserFrosting Documentation](https://learn.userfrosting.com) for more information.

- [Changelog](CHANGELOG.md)
- [Issues](https://github.com/userfrosting/UserFrosting/issues)
- [License](LICENSE.md)
- [Style Guide](STYLE-GUIDE.md)

## Contributing

This project exists thanks to all the people who contribute. If you're interested in contributing to the UserFrosting codebase, please see our [contributing guidelines](https://github.com/userfrosting/UserFrosting/blob/5.2/.github/CONTRIBUTING.md) as well as our [style guidelines](.github/STYLE-GUIDE.md).

[![](https://opencollective.com/userfrosting/contributors.svg?width=890&button=true)](https://github.com/userfrosting/sprinkle-core/graphs/contributors)
