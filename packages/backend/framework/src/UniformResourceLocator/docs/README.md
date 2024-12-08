# Table of Content

<!-- TOC -->

- [Table of Content](#table-of-content)
- [Structure and Logic](#structure-and-logic)
  - [Some Definitions](#some-definitions)
    - [Locator](#locator)
    - [Location](#location)
    - [Stream](#stream)
    - [Shared Stream](#shared-stream)
    - [URI](#uri)
    - [Resource](#resource)
  - [Overlaps and a question of priority](#overlaps-and-a-question-of-priority)
  - [Stream Wrappers](#stream-wrappers)
- [General Usage](#general-usage)
  - [Creating the Locator](#creating-the-locator)
  - [Adding Streams](#adding-streams)
    - [Shared Stream](#shared-stream-1)
  - [Adding Locations](#adding-locations)
  - [Finding Resources](#finding-resources)
  - [Listing Resources](#listing-resources)
  - [Resources](#resources)
  - [Streams](#streams)
    - [Stream Object](#stream-object)
  - [Locations](#locations)
    - [Location Object](#location-object)

<!-- /TOC -->

# Structure and Logic

## Some Definitions

Let's start by defining terms used in this context.

### Locator

**The locator is the tool used to find resources.** If we take example on a office building, the Locator knows how many floor (locations) there are in the building, which rooms (streams) be found on each floors. It can search each room on each floor for the resources you are looking for. Think of it like the receptionist of the office building that tell you where to find the person you're looking for for.

### Location

Locations are possible places resources could be. Typically, each framework or package in our project will be added to the location list. Locations are the floors of our office building. It's assumed here each package (each floor) has the same structure.

### Stream

**A stream is the definition of what we can find at each location.** A stream is composed of a **scheme** and a **path**. The **scheme** defines what we are looking for. Are we looking for a person, a conference room, a picture, a template, etc. The **path** is the location of this element inside the location. Ie. where on each floor we can find people (at desks), picture (on the wall), sinks (in the bathroom) or the templates (in `/style/template` directory).

A stream doesn't need to physically exist at each location. For example, one floor of our office building might not have a conference room, and that's fine. 

### Shared Stream

A streams can also be shared among all locations. For example, the parking spaces outside of the office building. It's not a floor on it's own, but it can still hold some resources, may it be cars, which you won't find on _floors_, but also trash cans or lights that can found everywhere. 

In a framework environment, this can be seen as a directory used to write log files for example. A log is not tied to a specific framework or location, but they can all use it.

### URI

The streams themselves creates a Uniform Resource Identifiers or **URI** in the form of `{scheme}://{path}`. URIs are a very strong concept that decouples resource location completely from the mechanisms of individual frameworks or in this case, locations. 

Furthermore, context-specific schemes can be used to simplify a search path. For example, instead of `file://Bundle/WebProfilerBundle/Resources/config/routing/wdt.json`, a `config` scheme can be used to regroup everything related to the `Bundle/WebProfilerBundle/Resources/config` path: `config://routing/wdt.json`. 

To relate to our office building metaphor, the URI is the question you ask the receptionist when you're looking for someone.

### Resource

**A resource is what you are looking for.** A resource can be any file : a template file, a configuration file, an image or any other kind of tangible asset in your project.

When getting info about a particular resource, the locator will typically return instance of the **Resource** object. This model is essentially a representation of a file/location and it's metadata. Those metadata can be used to get the path of the resource. It can also be used to get more detailed information including in which location the file was found. A resource can also be cast to string, in which case the absolute path of the file will be returned.

## Overlaps and a question of priority

In this concept, multiple locations can contain a resource with the same name. When looking for one specific resource without any knowledge of it's location, we can't be presented with all options. One most win over the other. This is why locations include the concept of **priority loading**. Simply put, the last location added wins.

Let's say we're looking for a conference room in the office building. We will start searching, from the top most most floor going down until we find one. Once we found a conference room, we stop our search and return it. There might be other conference rooms a floor below, but we don't care. Top floor wins. This might seams cruel, but when using multiple external packages, you might need to overwrite _something_ one defines with more restrictive of customized data.

Nonetheless, we can still manage to return all resources (conference room) available, no worries. More on this in a bit. 

## Stream Wrappers

A consequence of using URIs for identifying resources is a [stream wrapper](http://www.php.net/manual/en/class.streamwrapper.php) will be defined around the resource locator. While the locator can be used to find the full path of a resource or other file using the [resource object](#resource), the stream wrapper definition makes it possible to use a resource URIs directly with built-in PHP functions such as `fopen` and `file_get_contents`. For example :

```
echo file_get_contents('config://routing/wdt.json');
```

# General Usage

See [API documentation for more information](api/#class-userfrostinguniformresourcelocatorresourcelocator).

## Creating the Locator

```
$locator = new ResourceLocator('./app');
```

The locator accept an optional argument, `$basePath`. This can be used to define the base search path for the locator. In most cases, it will be project root folder.

`Filesystem` (abstraction layer to access the files) and `StreamBuilder` (abstraction layer to manipulate the php Stream Wrappers) can be injected, otherwise they'll be automatically created. 

## Adding Streams

A stream can either be created directly or an existing stream can be registered with the locator.

For example, to create a stream with the `config://` scheme pointing to `data/config` in each location. In this case, the stream path (i.e. `data/config`) is relative to each location base path.

**Registering a ResourceStream object**:
```
$stream = new ResourceStream('config', 'data/config/');
$locator->addStream($stream); 
```

### Shared Stream

A shared stream can also be defined, outside any location. The scheme can overlap the non-shared version. In this case, the stream path (i.e. `config/`) is relative to **the locator** base path and the `shared` argument set to true.

**Registering a ResourceStream object**:
```
$stream = new ResourceStream('config', 'storage/config/', shared: true);
$locator->addStream($stream); 
```

## Adding Locations

Similar to streams, a location can either be created or an existing one can be registered with the locator.

Each location has a unique name and a path. For example, to register a **Floor 1** location pointing to `floors/1/` directory, as well as a **Floor 2** location pointing to `floors/2/` directory : 

**Registering a ResourceLocation object**:
```
$location = new ResourceLocation('Floor #1', 'floors/1/');
$locator->addLocation($location);

$location = new ResourceLocation('Floor #2', 'floors/2/');
$locator->addLocation($location);
```

**Creating a new location**:
```
$locator->registerLocation('Floor #1', 'floors/1/');
$locator->registerLocation('Floor #2', 'floors/2/');
```

> _N.B.: Registering a location object should always be preferred._

## Finding Resources

The `getResource` and `getResources` methods can be used to find resources for the specified URI. While `getResource` will return a single file (see [_Overlaps and a question of priority_](#overlaps-and-a-question-of-priority)), `getResources` will return all the resources available for that URI, sorted by priority.

```
$resources = $locator->getResources('config://default.json');
```

In this case, `$resources` will contain an array of [Resource objects](#resource-object), representing each `default.json` file found for each locations, as well as the shared stream:

- `app/storage/config/default.json`
- `app/floors/2/data/config/default.json`,
- `app/floors/1/data/config/default.json`,

> Note that Floor #2 is returned before Floor #1, as it's the last one to be registered. In a similar way, the shared stream is returned before the two floors, as it has been registered after the non-shared stream.

In this case, `$locator->getResource('config://default.json');` would return a [Resource object](#resource-object) representing `app/storage/config/default.json`.

If no resources can be found, `getResources` will return an empty array, while `getResource` will return `null`.

## Listing Resources

All available resources in a given directory can be listed using the `listResources` method. This method will also returns the resources recursively, unlike `getResources`. 

For example : 

```
$resources = $locator->listResources('config://');

/*
[
    'app/storage/config/default.json',
    'app/floors/2/data/config/production.json',
    'app/floors/1/data/config/develop.json',
]
*/
```

In the above example, if both location, including the shared stream, have a `default.json` file, only the top most file will be returned. To return all instances of every resources, the `all` flag can be used :

```
$resources = $locator->listResources('cars://', all: true);

/*
[
    'app/storage/config/default.json',
    'app/floors/2/data/config/default.json',
    'app/floors/2/data/config/production.json',
    'app/floors/1/data/config/default.json',
    'app/floors/1/data/config/develop.json',
]
*/
```

## Resources

Files found using the locator are represented by the *ResourceInterface* object. This can be used to access different metadata about a file in addition to the file path.

**Available methods :**

| Method                                      | Description                                                                                  |
| ------------------------------------------- | -------------------------------------------------------------------------------------------- |
| `getAbsolutePath(): string`                 | Returns the file absolute path.                                                              |
| `getPath(): string`                         | Returns the file relative path.                                                              |
| `getBasePath(): string`                     | Returns the path that comes after the `://` in the resource URI.                             |
| `getBasename(): string`                     | Returns the trailing name component (ex.: foo/test.txt -> test.txt).                         |
| `getExtension(): string`                    | Returns the resource extension (foo/test.txt -> txt).                                        |
| `getFilename(): string`                     | Returns the resource filename (foo/test.txt -> test).                                        |
| `getLocation(): ?ResourceLocationInterface` | Returns the location instance used to find the resource. Returns `null` for a shared stream. |
| `getStream(): ResourceStreamInterface`      | Returns the stream instance used to find the resource.                                       |
| `getUri(): string`                          | Returns the URI that can be used to retrieve this resource.                                  |
| `getLocatorBasePath(): string`              | Returns the base path of the global locator system.                                          |

See the [API Documentation](api/) for more information.


Note that a Resource object can be cast as a string to return the absolute path. Those two method are equivalent :

```
echo $locator->getResource(config://default.json)->getAbsolutePath();
// 'app/storage/config/default.json'

echo $locator->getResource(config://default.json);
// 'app/storage/config/default.json'
```

## Streams

The locator provides some methods to control registered streams. Since stream scheme (the part before the `://`) is unique, most streams are identified using schemes.

**Available methods :**
| Method                                                 | Description                                                                                                                                                                                                                    |
| ------------------------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| `getStream(string $scheme): ResourceStreamInterface[]` | Returns an array of [Stream Object](#Stream-Object) registered for the specified scheme. Multiple stream can be registered of a single stream. Throws `StreamNotFoundException` if scheme doesn't match any registered stream. |
| `getStreams(): ResourceStreamInterface[]`              | Returns an array of [Stream Object](#Stream-Object).                                                                                                                                                                           |
| `isStream(string $uri): bool`                          | Returns true if URI is resolvable, i.e. valid and bound to a registered scheme. Can be a file or a path.                                                                                                                       |
| `schemeExists(string $scheme): bool`                   | Return if a stream is registered tor the specified scheme.                                                                                                                                                                     |
| `listSchemes(): string[]`                              | Return a list of all the stream scheme registered.                                                                                                                                                                             |
| `removeStream(string $scheme): static`                 | Unregister all stream associated with the specified scheme.                                                                                                                                                                    |

See the [API Documentation](api/) for more information.

### Stream Object

Streams are represented by the *ResourceStreamInterface* object.

**Available methods :**
| Method                | Description                                                                                                     |
| --------------------- | --------------------------------------------------------------------------------------------------------------- |
| `getPath(): string`   | Return the base path for the stream. In a non shared stream, it would be the relative path inside the location. |
| `getScheme(): string` | Return the stream scheme (the part before the `://`).                                                           |
| `isShared(): bool`    | Return true or false if a stream is shared.                                                                     |
| `isReadonly(): bool`  | Return true or false if a stream register a readonly `StreamWrapper`.                                           |

See the [API Documentation](api/) for more information.

## Locations

The locator also provides methods to control registered locations. Each location have a **name** and a **path**.

| Method                                                 | Description                                                                                                                                                          |
| ------------------------------------------------------ | -------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `getLocation(string $name): ResourceLocationInterface` | Returns a [location object](#Location-Object) for the location name. Return `LocationNotFoundException` if the specified name doesn't match any registered location. |
| `getLocations(): ResourceLocationInterface[]`          | Returns an array of [location objects](#Location-object) registered on the locator.                                                                                  |
| `listLocations(): string[]`                            | List all available location registered with the locator as an associative array (`name => path`).                                                                    |
| `locationExist(string $name): bool`                    | Returns true or false if the specified location name is registered.                                                                                                  |
| `removeLocation(string $name): static`                 | Unregister the location associated with the specified name.                                                                                                        |

See the [API Documentation](api/) for more information.

### Location Object

Streams are represented by the *ResourceLocationInterface* object.

**Available methods :**

| Method              | Description                    |
| ------------------- | ------------------------------ |
| `getName(): string` | Return the location name.      |
| `getPath(): string` | Return the location base path. |

See the [API Documentation](api/) for more information.