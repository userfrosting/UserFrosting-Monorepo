# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [5.1.2](https://github.com/userfrosting/sprinkle-admin/compare/5.1.1...5.1.2)
- Fix Unable to create a user without a group on MySQL (Fix [#1273](https://github.com/userfrosting/UserFrosting/issues/1273))

## [5.1.1](https://github.com/userfrosting/sprinkle-admin/compare/5.1.0...5.1.1)
- Fix issue when a Group Administrator without the `create_user_field` permission creates a new user, the new user SHOULD inherit the admin's group (Fix [#1256](https://github.com/userfrosting/UserFrosting/issues/1256))

## [5.1.0](https://github.com/userfrosting/sprinkle-admin/compare/5.0.1...5.1.0)
- Drop PHP 8.1 support, add PHP 8.3 support
- Update to Laravel 10
- Update to PHPUnit 10
- Test against MariaDB [#1238](https://github.com/userfrosting/UserFrosting/issues/1238)
- Update FontAwesome 6 references

## [5.0.2](https://github.com/userfrosting/sprinkle-admin/compare/5.0.1...5.0.2)
- Fix editing a role permissions erase all permissions - Fix [#1240](https://github.com/userfrosting/UserFrosting/issues/1240)

## [5.0.1](https://github.com/userfrosting/sprinkle-admin/compare/5.0.0...5.0.1)
- Update success message when admin resets password for a user - Fix [#852](https://github.com/userfrosting/UserFrosting/issues/852)

## [5.0.0-alpha3](https://github.com/userfrosting/sprinkle-admin/compare/5.0.0-alpha2...5.0.0-alpha3)
- Update cache clearing action.
  
## [5.0.0-alpha2](https://github.com/userfrosting/sprinkle-admin/compare/5.0.0-alpha1...5.0.0-alpha2)
- [Exceptions] Update exception inheritance.