# Config module for UserFrosting 4

## Usage

Create a file `default.php`, in a directory `/path/to/core/config/`:

**default.php**

```
return [
    'contacts' => [
        'housekeeper' => [
            'name' => 'Alex',
            'email' => 'alex@cleansthetoilet.com'
        ]
    ]
];
```

Suppose now you have another config file which can override values in this base config file.  For example, in `/path/to/plugin/config/`, you have:

**default.php**

```
return [
    'contacts' => [
        'housekeeper' => [
            'name' => 'Alex "the man" Weissman'
        ]
    ]
];
```

You can generate an ordered list of these configuration files using the `ConfigPathBuilder` class, and merge them together using an instance of `UserFrosting\Support\Respository\Loader\ArrayFileLoader`.

### Path builder

Create `ResourceLocator` and `ConfigPathBuilder` classes to build a list of configuration files:

```
$locator = new ResourceLocator(__DIR__);
$locator->registerLocation('core', 'path/to/core');
$locator->registerLocation('plugin', 'path/to/plugin');
$locator->registerStream('config', '', 'config/');

$builder = new ConfigPathBuilder($locator, 'config://');
$paths = $builder->buildPaths();

// Generates a list of paths:
[
    '/core/config/default.php'
    '/plugin/config/default.php'
]
```

### Data loader

You can then use the `ArrayFileLoader` class to load and merge all configuration data from this list of paths:

```
$loader = new \UserFrosting\Support\Respository\Loader\ArrayFileLoader($builder->buildPaths());
$config = new \UserFrosting\Support\Respository\Repository($loader->load());
```

Config files in multiple paths will be merged in the order in which the paths are specified.  You can now access your configuration data via the standard `Repository` methods:

```
echo $config->get('contacts.housekeeper.name');
// Prints 'Alex'
```

You can also specify environment-specific config files in each path.  If an environment name is passed to `buildPaths()`, `ConfigPathBuilder` will merge in the environment-specific file in a path immediately after merging in `default.php`:

**development.php**

```
return [
    'database' => [
        'password' => 'sup3rC-cr3t'
    ]
];
```

To merge this in, you would call:

```
$paths = $builder->buildPaths('development');
```
