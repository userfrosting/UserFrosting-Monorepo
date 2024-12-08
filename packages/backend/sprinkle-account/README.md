# UserFrosting 5.2 Account Sprinkle

[![Version](https://img.shields.io/github/v/release/userfrosting/sprinkle-account?include_prereleases)](https://github.com/userfrosting/sprinkle-account/releases)
![PHP Version](https://img.shields.io/badge/php-%5E8.1-brightgreen)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-account/Build.yml?branch=5.2&logo=github)](https://github.com/userfrosting/sprinkle-account/actions)
[![Codecov](https://codecov.io/gh/userfrosting/sprinkle-account/branch/5.2/graph/badge.svg)](https://app.codecov.io/gh/userfrosting/sprinkle-account/branch/5.2)
[![StyleCI](https://github.styleci.io/repos/448371817/shield?branch=5.2&style=flat)](https://github.styleci.io/repos/448371817)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-account/PHPStan.yml?branch=5.2&label=PHPStan)](https://github.com/userfrosting/sprinkle-account/actions/workflows/PHPStan.yml)
[![Join the chat](https://img.shields.io/badge/Chat-UserFrosting-brightgreen?logo=Rocket.Chat)](https://chat.userfrosting.com)
[![Donate](https://img.shields.io/badge/Open_Collective-Donate-blue?logo=Open%20Collective)](https://opencollective.com/userfrosting#backer)
[![Donate](https://img.shields.io/badge/Ko--fi-Donate-blue?logo=ko-fi&logoColor=white)](https://ko-fi.com/lcharette)

## By [Alex Weissman](https://alexanderweissman.com) and [Louis Charette](https://bbqsoftwares.com)

Copyright (c) 2013-2024, free to use in personal and commercial software as per the [license](LICENSE.md).

UserFrosting is a secure, modern user management system written in PHP and built on top of the [Slim Microframework](http://www.slimframework.com/), [Twig](http://twig.sensiolabs.org/) templating engine, and [Eloquent](https://laravel.com/docs/10.x/eloquent#introduction) ORM.

This **Account sprinkle** handles user modeling and authentication, user groups, roles, and access control. It contains the routes, templates, and controllers needed to implement pages for registration, password reset, login, and more.

## Installation
1. Require in your [UserFrosting](https://github.com/userfrosting/UserFrosting) project : 
    ``` 
    composer require userfrosting/sprinkle-account
    ```

2. Add the Sprinkle to your Sprinkle Recipe : 
    ```php
    public function getSprinkles(): array
    {
        return [
            \UserFrosting\Sprinkle\Account\Account::class,
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
- [Style Guide](https://github.com/userfrosting/.github/blob/main/.github/STYLE-GUIDE.md)

## Contributing

This project exists thanks to all the people who contribute. If you're interested in contributing to the UserFrosting codebase, please see our [contributing guidelines](https://github.com/userfrosting/UserFrosting/blob/5.2/.github/CONTRIBUTING.md) as well as our [style guidelines](.github/STYLE-GUIDE.md).

[![](https://opencollective.com/userfrosting/contributors.svg?width=890&button=true)](https://github.com/userfrosting/sprinkle-core/graphs/contributors)
