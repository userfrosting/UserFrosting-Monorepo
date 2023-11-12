# UserFrosting 5.0 Core Sprinkle

[![Version](https://img.shields.io/github/v/release/userfrosting/sprinkle-core?include_prereleases)](https://github.com/userfrosting/sprinkle-core/releases)
![PHP Version](https://img.shields.io/badge/php-%5E8.0-brightgreen)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](LICENSE.md)
[![Build](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-core/Build.yml?branch=5.0&logo=github)](https://github.com/userfrosting/sprinkle-core/actions)
[![Codecov](https://codecov.io/gh/userfrosting/sprinkle-core/branch/5.0/graph/badge.svg)](https://app.codecov.io/gh/userfrosting/sprinkle-core/branch/5.0)
[![StyleCI](https://github.styleci.io/repos/372359383/shield?branch=5.0&style=flat)](https://github.styleci.io/repos/372359383)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/userfrosting/sprinkle-core/PHPStan.yml?branch=5.0&label=PHPStan)](https://github.com/userfrosting/sprinkle-core/actions/workflows/PHPStan.yml)
[![Join the chat](https://img.shields.io/badge/Chat-UserFrosting-brightgreen?logo=Rocket.Chat)](https://chat.userfrosting.com)
[![Donate](https://img.shields.io/badge/Open_Collective-Donate-blue?logo=Open%20Collective
)](https://opencollective.com/userfrosting#backer)
[![Donate](https://img.shields.io/badge/Ko--fi-Donate-blue?logo=ko-fi&logoColor=white
)](https://ko-fi.com/lcharette)

## By [Alex Weissman](https://alexanderweissman.com) and [Louis Charette](https://bbqsoftwares.com)

Copyright (c) 2019-2023, free to use in personal and commercial software as per the [license](LICENSE.md).

UserFrosting is a secure, modern user management system written in PHP and built on top of the [Slim Microframework](http://www.slimframework.com/), [Twig](http://twig.sensiolabs.org/) templating engine, and [Eloquent](https://laravel.com/docs/5.8/eloquent#introduction) ORM.

This **Core Sprinkle** provides most of the "heavy lifting" PHP code. It provides all the necessary services for database, templating, error handling, mail support, request throttling, and more.

## Installation
1. Require in your [UserFrosting](https://github.com/userfrosting/UserFrosting) project : 
    ``` 
    composer require userfrosting/sprinkle-core
    ```

2. Add the Sprinkle to your Sprinkle Recipe : 
    ```php
    public function getSprinkles(): array
    {
        return [
            \UserFrosting\Sprinkle\Core\Core::class,
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

This project exists thanks to all the people who contribute. If you're interested in contributing to the UserFrosting codebase, please see our [contributing guidelines](https://github.com/userfrosting/UserFrosting/blob/5.0/.github/CONTRIBUTING.md) as well as our [style guidelines](.github/STYLE-GUIDE.md).

[![](https://opencollective.com/userfrosting/contributors.svg?width=890&button=true)](https://github.com/userfrosting/sprinkle-core/graphs/contributors)
