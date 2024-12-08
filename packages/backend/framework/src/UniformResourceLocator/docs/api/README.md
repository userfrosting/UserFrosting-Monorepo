# Documentation

## Table of Contents

| Method | Description |
|--------|-------------|
| [**LocationNotFoundException**](#LocationNotFoundException) | LocationNotFoundException Used when a Location is not registered. |
| [**Normalizer**](#Normalizer) |  |
| [Normalizer::normalize](#Normalizernormalize) | Returns the canonicalize URI on success. |
| [Normalizer::normalizeParts](#NormalizernormalizeParts) | Returns the canonicalize URI on success. |
| [Normalizer::normalizePath](#NormalizernormalizePath) | Normalize a path: - Make sure all `\` (from a Windows path) are changed to `/` - Make sure a trailing slash is present - Doesn&#039;t change the beginning of the path (don&#039;t change absolute / relative path), but will change `C:\` to `C:/`. |
| [**ReadOnlyStream**](#ReadOnlyStream) | Implements Read Only Streams. |
| [ReadOnlyStream::stream_open](#ReadOnlyStreamstream_open) | {@inheritDoc} |
| [ReadOnlyStream::stream_lock](#ReadOnlyStreamstream_lock) | {@inheritDoc} |
| [ReadOnlyStream::stream_metadata](#ReadOnlyStreamstream_metadata) | {@inheritDoc} |
| [ReadOnlyStream::stream_write](#ReadOnlyStreamstream_write) | {@inheritDoc} |
| [ReadOnlyStream::unlink](#ReadOnlyStreamunlink) | {@inheritDoc} |
| [ReadOnlyStream::rename](#ReadOnlyStreamrename) | {@inheritDoc} |
| [ReadOnlyStream::mkdir](#ReadOnlyStreammkdir) | {@inheritDoc} |
| [ReadOnlyStream::rmdir](#ReadOnlyStreamrmdir) | {@inheritDoc} |
| [**Resource**](#Resource) | The representation of a resource. |
| [Resource::__construct](#Resource__construct) |  |
| [Resource::getUri](#ResourcegetUri) | Get Resource URI. |
| [Resource::getBasePath](#ResourcegetBasePath) | Get the resource base path, aka the path that comes after the `://`. |
| [Resource::getFilename](#ResourcegetFilename) | Extract the resource filename (test.txt -&gt; test). |
| [Resource::getBasename](#ResourcegetBasename) | Extract the trailing name component (test.txt -&gt; test.txt). |
| [Resource::getExtension](#ResourcegetExtension) | Extract the resource extension (test.txt -&gt; txt). |
| [Resource::getLocation](#ResourcegetLocation) |  |
| [Resource::getAbsolutePath](#ResourcegetAbsolutePath) |  |
| [Resource::__toString](#Resource__toString) | Magic function to convert the class into the resource absolute path. |
| [Resource::getPath](#ResourcegetPath) |  |
| [Resource::getLocatorBasePath](#ResourcegetLocatorBasePath) |  |
| [Resource::getStream](#ResourcegetStream) |  |
| [**ResourceLocation**](#ResourceLocation) | The representation of a location. |
| [ResourceLocation::__construct](#ResourceLocation__construct) |  |
| [ResourceLocation::getName](#ResourceLocationgetName) |  |
| [ResourceLocation::getPath](#ResourceLocationgetPath) |  |
| [**ResourceLocator**](#ResourceLocator) | The locator is used to find resources. |
| [ResourceLocator::__construct](#ResourceLocator__construct) |  |
| [ResourceLocator::__invoke](#ResourceLocator__invoke) | Alias for findResource(). |
| [ResourceLocator::addStream](#ResourceLocatoraddStream) | Add an existing ResourceStream to the stream list. |
| [ResourceLocator::registerStream](#ResourceLocatorregisterStream) | Register a new stream. |
| [ResourceLocator::registerSharedStream](#ResourceLocatorregisterSharedStream) | Register a new shared stream. |
| [ResourceLocator::removeStream](#ResourceLocatorremoveStream) | Unregister the specified stream. |
| [ResourceLocator::getStream](#ResourceLocatorgetStream) | Return all registered Streams for a specific scheme. |
| [ResourceLocator::getStreams](#ResourceLocatorgetStreams) | Return information about a all registered stream. |
| [ResourceLocator::listSchemes](#ResourceLocatorlistSchemes) | Return a list of all the stream scheme registered. |
| [ResourceLocator::schemeExists](#ResourceLocatorschemeExists) | Returns true if a stream has been defined. |
| [ResourceLocator::addLocation](#ResourceLocatoraddLocation) | Add an existing ResourceLocation instance to the location list. |
| [ResourceLocator::registerLocation](#ResourceLocatorregisterLocation) | Register a new location. |
| [ResourceLocator::removeLocation](#ResourceLocatorremoveLocation) | Unregister the specified location. |
| [ResourceLocator::getLocation](#ResourceLocatorgetLocation) | Get a location instance based on it&#039;s name. |
| [ResourceLocator::getLocations](#ResourceLocatorgetLocations) | Get a a list of all registered locations. |
| [ResourceLocator::listLocations](#ResourceLocatorlistLocations) | Return a list of all the locations registered by name. |
| [ResourceLocator::locationExist](#ResourceLocatorlocationExist) | Returns true if a location has been defined. |
| [ResourceLocator::getResource](#ResourceLocatorgetResource) | Return a resource instance. |
| [ResourceLocator::getResources](#ResourceLocatorgetResources) | Return a list of resources instances. |
| [ResourceLocator::listResources](#ResourceLocatorlistResources) | List all resources found at a given uri. |
| [ResourceLocator::reset](#ResourceLocatorreset) | Reset locator by removing all the registered streams and locations. |
| [ResourceLocator::isStream](#ResourceLocatorisStream) | Returns true if uri is resolvable by using locator. |
| [ResourceLocator::findResource](#ResourceLocatorfindResource) | Find highest priority instance from a resource. Return the path for said resourceFor example, if looking for a `test.json` resource, only the top priorityinstance of `test.json` found will be returned. |
| [ResourceLocator::findResources](#ResourceLocatorfindResources) | Find all instances from a resource. Return an array of paths for said resourceFor example, if looking for a `test.json` resource, all instanceof `test.json` found will be listed. |
| [ResourceLocator::getStreamBuilder](#ResourceLocatorgetStreamBuilder) |  |
| [ResourceLocator::getBasePath](#ResourceLocatorgetBasePath) |  |
| [**ResourceStream**](#ResourceStream) | The representation of a stream. |
| [ResourceStream::__construct](#ResourceStream__construct) |  |
| [ResourceStream::getScheme](#ResourceStreamgetScheme) |  |
| [ResourceStream::getPath](#ResourceStreamgetPath) | Path default to scheme when null. |
| [ResourceStream::isShared](#ResourceStreamisShared) |  |
| [ResourceStream::isReadonly](#ResourceStreamisReadonly) | Is the stream read only. |
| [**Stream**](#Stream) | Implements Read/Write Streams. |
| [Stream::setLocator](#StreamsetLocator) |  |
| [Stream::stream_open](#Streamstream_open) | {@inheritDoc} |
| [Stream::stream_close](#Streamstream_close) | {@inheritDoc} |
| [Stream::stream_lock](#Streamstream_lock) | {@inheritDoc} |
| [Stream::stream_metadata](#Streamstream_metadata) | {@inheritDoc} |
| [Stream::stream_read](#Streamstream_read) | {@inheritDoc} |
| [Stream::stream_write](#Streamstream_write) | {@inheritDoc} |
| [Stream::stream_eof](#Streamstream_eof) | {@inheritDoc} |
| [Stream::stream_seek](#Streamstream_seek) | {@inheritDoc} |
| [Stream::stream_flush](#Streamstream_flush) | {@inheritDoc} |
| [Stream::stream_tell](#Streamstream_tell) | {@inheritDoc} |
| [Stream::stream_stat](#Streamstream_stat) | {@inheritDoc} |
| [Stream::unlink](#Streamunlink) | {@inheritDoc} |
| [Stream::rename](#Streamrename) | {@inheritDoc} |
| [Stream::mkdir](#Streammkdir) | {@inheritDoc} |
| [Stream::rmdir](#Streamrmdir) | {@inheritDoc} |
| [Stream::url_stat](#Streamurl_stat) | {@inheritDoc} |
| [Stream::dir_opendir](#Streamdir_opendir) | {@inheritDoc} |
| [Stream::dir_readdir](#Streamdir_readdir) | {@inheritDoc} |
| [Stream::dir_rewinddir](#Streamdir_rewinddir) | {@inheritDoc} |
| [Stream::dir_closedir](#Streamdir_closedir) | {@inheritDoc} |
| [**StreamBuilder**](#StreamBuilder) | Class StreamBuilder. |
| [StreamBuilder::__construct](#StreamBuilder__construct) | StreamBuilder constructor. |
| [StreamBuilder::add](#StreamBuilderadd) |  |
| [StreamBuilder::remove](#StreamBuilderremove) |  |
| [StreamBuilder::getStreams](#StreamBuildergetStreams) |  |
| [StreamBuilder::isStream](#StreamBuilderisStream) |  |
| [**StreamNotFoundException**](#StreamNotFoundException) | StreamNotFoundException Used when a path is not registered. |

## LocationNotFoundException

LocationNotFoundException Used when a Location is not registered.



* Full name: \UserFrosting\UniformResourceLocator\Exception\LocationNotFoundException
* Parent class: 


## Normalizer





* Full name: \UserFrosting\UniformResourceLocator\Normalizer


### Normalizer::normalize

Returns the canonicalize URI on success.

```php
Normalizer::normalize( string uri ): string
```

The resulting path will have no '/./' or '/../' components. Trailing delimiter `/` is kept.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |


**Return Value:**

Canonicalize URI as "scheme://path" or "path" if no scheme is present.



---
### Normalizer::normalizeParts

Returns the canonicalize URI on success.

```php
Normalizer::normalizeParts( string uri ): string[]
```

The resulting path will have no '/./' or '/../' components. Trailing delimiter `/` is kept.

* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |


**Return Value:**

As [scheme, path] array



---
### Normalizer::normalizePath

Normalize a path:
 - Make sure all `\` (from a Windows path) are changed to `/`
 - Make sure a trailing slash is present
 - Doesn't change the beginning of the path (don't change absolute / relative path), but will change `C:\` to `C:/`.

```php
Normalizer::normalizePath( string path ): string
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |


**Return Value:**

Return false if path is invalid



---
## ReadOnlyStream

Implements Read Only Streams.



* Full name: \UserFrosting\UniformResourceLocator\StreamWrapper\ReadOnlyStream
* Parent class: \UserFrosting\UniformResourceLocator\StreamWrapper\Stream


### ReadOnlyStream::stream_open

{@inheritDoc}

```php
ReadOnlyStream::stream_open( string uri, string mode, int options, ?string &opened_path ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |
| `mode` | **string** |  |
| `options` | **int** |  |
| `opened_path` | **?string** |  |


**Return Value:**





---
### ReadOnlyStream::stream_lock

{@inheritDoc}

```php
ReadOnlyStream::stream_lock( int operation ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `operation` | **int** |  |


**Return Value:**





---
### ReadOnlyStream::stream_metadata

{@inheritDoc}

```php
ReadOnlyStream::stream_metadata( string uri, int option, mixed value ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |
| `option` | **int** |  |
| `value` | **mixed** |  |


**Return Value:**





---
### ReadOnlyStream::stream_write

{@inheritDoc}

```php
ReadOnlyStream::stream_write( string data ): int
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `data` | **string** |  |


**Return Value:**





---
### ReadOnlyStream::unlink

{@inheritDoc}

```php
ReadOnlyStream::unlink( string uri ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |


**Return Value:**





---
### ReadOnlyStream::rename

{@inheritDoc}

```php
ReadOnlyStream::rename( string path_from, string path_to ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path_from` | **string** |  |
| `path_to` | **string** |  |


**Return Value:**





---
### ReadOnlyStream::mkdir

{@inheritDoc}

```php
ReadOnlyStream::mkdir( string path, int mode, int options ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `mode` | **int** |  |
| `options` | **int** |  |


**Return Value:**





---
### ReadOnlyStream::rmdir

{@inheritDoc}

```php
ReadOnlyStream::rmdir( string path, int options ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `options` | **int** |  |


**Return Value:**





---
## Resource

The representation of a resource.

Resources are used to represent a file with info regarding the stream and
Location used to find it. When a resource is created, we save the stream used
to find it, the location where it was found, and the absolute and relative
paths of the file. Using this information, we can later rebuilt the URI used
to find this file. Since the full path will contains the relative location of
the stream and location inside the filesystem, this information will be
removed to recreate the relative 'basepath' of the file, allowing the
recreation of the uri (scheme://basePath).

* Full name: \UserFrosting\UniformResourceLocator\Resource
* This class implements: \UserFrosting\UniformResourceLocator\ResourceInterface


### Resource::__construct



```php
Resource::__construct( \UserFrosting\UniformResourceLocator\ResourceStreamInterface stream, \UserFrosting\UniformResourceLocator\ResourceLocationInterface|null location, string path, string locatorBasePath = '' ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `stream` | **\UserFrosting\UniformResourceLocator\ResourceStreamInterface** | ResourceStream used to locate this resource |
| `location` | **\UserFrosting\UniformResourceLocator\ResourceLocationInterface\|null** | ResourceLocation used to locate this resource |
| `path` | **string** | Resource path, relative to the locator base path, and containing the stream and location path |
| `locatorBasePath` | **string** | Locator base Path (default to &#039;&#039;) |


**Return Value:**





---
### Resource::getUri

Get Resource URI.

```php
Resource::getUri(  ): string
```





**Return Value:**





---
### Resource::getBasePath

Get the resource base path, aka the path that comes after the `://`.

```php
Resource::getBasePath(  ): string
```

To to this, we use the relative path and remove
the stream and location base path. For example, a stream with a base path
of `data/foo/`, will return a relative path for every resource it find as
`data/foo/filename.txt`. So we want to remove the `data/foo/` part to
keep only the `filename.txt` part, aka the part after the `://` in the URI.

Same goes for the location part, which comes before the stream:
`locations/locationA/data/foo`



**Return Value:**





---
### Resource::getFilename

Extract the resource filename (test.txt -> test).

```php
Resource::getFilename(  ): string
```





**Return Value:**





---
### Resource::getBasename

Extract the trailing name component (test.txt -> test.txt).

```php
Resource::getBasename(  ): string
```





**Return Value:**





---
### Resource::getExtension

Extract the resource extension (test.txt -> txt).

```php
Resource::getExtension(  ): string
```





**Return Value:**





---
### Resource::getLocation



```php
Resource::getLocation(  ): \UserFrosting\UniformResourceLocator\ResourceLocationInterface|null
```





**Return Value:**





---
### Resource::getAbsolutePath



```php
Resource::getAbsolutePath(  ): string
```





**Return Value:**





---
### Resource::__toString

Magic function to convert the class into the resource absolute path.

```php
Resource::__toString(  ): string
```





**Return Value:**

The resource absolute path



---
### Resource::getPath



```php
Resource::getPath(  ): string
```





**Return Value:**





---
### Resource::getLocatorBasePath



```php
Resource::getLocatorBasePath(  ): string
```





**Return Value:**





---
### Resource::getStream



```php
Resource::getStream(  ): \UserFrosting\UniformResourceLocator\ResourceStreamInterface
```





**Return Value:**





---
## ResourceLocation

The representation of a location.



* Full name: \UserFrosting\UniformResourceLocator\ResourceLocation
* This class implements: \UserFrosting\UniformResourceLocator\ResourceLocationInterface


### ResourceLocation::__construct



```php
ResourceLocation::__construct( string name, string|null path = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `name` | **string** |  |
| `path` | **string\|null** |  |


**Return Value:**





---
### ResourceLocation::getName



```php
ResourceLocation::getName(  ): string
```





**Return Value:**





---
### ResourceLocation::getPath



```php
ResourceLocation::getPath(  ): string
```





**Return Value:**





---
## ResourceLocator

The locator is used to find resources.



* Full name: \UserFrosting\UniformResourceLocator\ResourceLocator
* This class implements: \UserFrosting\UniformResourceLocator\ResourceLocatorInterface


### ResourceLocator::__construct



```php
ResourceLocator::__construct( string basePath = '', \Illuminate\Filesystem\Filesystem|null filesystem = null, \UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder|null streamBuilder = null ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `basePath` | **string** |  |
| `filesystem` | **\Illuminate\Filesystem\Filesystem\|null** |  |
| `streamBuilder` | **\UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder\|null** |  |


**Return Value:**





---
### ResourceLocator::__invoke

Alias for findResource().

```php
ResourceLocator::__invoke( string uri ): string|null
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |


**Return Value:**





---
### ResourceLocator::addStream

Add an existing ResourceStream to the stream list.

```php
ResourceLocator::addStream( \UserFrosting\UniformResourceLocator\ResourceStreamInterface stream ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `stream` | **\UserFrosting\UniformResourceLocator\ResourceStreamInterface** |  |


**Return Value:**





---
### ResourceLocator::registerStream

Register a new stream.

```php
ResourceLocator::registerStream( string scheme, string|array|null paths = null, bool shared = false, bool readonly = false ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |
| `paths` | **string\|array\|null** | (default null). When using null path, the scheme will be used as a path |
| `shared` | **bool** | (default false) Shared resources are not affected by locations |
| `readonly` | **bool** |  |


**Return Value:**





---
### ResourceLocator::registerSharedStream

Register a new shared stream.

```php
ResourceLocator::registerSharedStream( string scheme, string|string[]|null paths = null, bool readonly = false ): static
```

Shortcut for registerStream with $shared flag set to true.

* **Warning:** this method is **deprecated**. This means that this method will likely be removed in a future version.

**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |
| `paths` | **string\|string[]\|null** | (default null). When using null path, the scheme will be used as a path |
| `readonly` | **bool** |  |


**Return Value:**





---
### ResourceLocator::removeStream

Unregister the specified stream.

```php
ResourceLocator::removeStream( string scheme ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** | The stream scheme |


**Return Value:**





---
### ResourceLocator::getStream

Return all registered Streams for a specific scheme.

```php
ResourceLocator::getStream( string scheme ): \UserFrosting\UniformResourceLocator\ResourceStreamInterface[]
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** | The stream scheme |


**Return Value:**





---
### ResourceLocator::getStreams

Return information about a all registered stream.

```php
ResourceLocator::getStreams(  ): \UserFrosting\UniformResourceLocator\ResourceStreamInterface[][]
```





**Return Value:**





---
### ResourceLocator::listSchemes

Return a list of all the stream scheme registered.

```php
ResourceLocator::listSchemes(  ): string[]
```





**Return Value:**

An array of registered scheme => location



---
### ResourceLocator::schemeExists

Returns true if a stream has been defined.

```php
ResourceLocator::schemeExists( string scheme ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** | The stream scheme |


**Return Value:**





---
### ResourceLocator::addLocation

Add an existing ResourceLocation instance to the location list.

```php
ResourceLocator::addLocation( \UserFrosting\UniformResourceLocator\ResourceLocationInterface location ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `location` | **\UserFrosting\UniformResourceLocator\ResourceLocationInterface** |  |


**Return Value:**





---
### ResourceLocator::registerLocation

Register a new location.

```php
ResourceLocator::registerLocation( string name, ?string path = null ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `name` | **string** | The location name |
| `path` | **?string** | The location base path (default null) |


**Return Value:**





---
### ResourceLocator::removeLocation

Unregister the specified location.

```php
ResourceLocator::removeLocation( string name ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `name` | **string** | The location name |


**Return Value:**





---
### ResourceLocator::getLocation

Get a location instance based on it's name.

```php
ResourceLocator::getLocation( string name ): \UserFrosting\UniformResourceLocator\ResourceLocationInterface
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `name` | **string** | The location name |


**Return Value:**





---
### ResourceLocator::getLocations

Get a a list of all registered locations.

```php
ResourceLocator::getLocations(  ): \UserFrosting\UniformResourceLocator\ResourceLocationInterface[]
```





**Return Value:**





---
### ResourceLocator::listLocations

Return a list of all the locations registered by name.

```php
ResourceLocator::listLocations(  ): string[]
```





**Return Value:**

An array of registered name => location



---
### ResourceLocator::locationExist

Returns true if a location has been defined.

```php
ResourceLocator::locationExist( string name ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `name` | **string** | The location name |


**Return Value:**





---
### ResourceLocator::getResource

Return a resource instance.

```php
ResourceLocator::getResource( string uri, bool all = false ): \UserFrosting\UniformResourceLocator\ResourceInterface|null
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | Input URI to be searched (can be a file/path) |
| `all` | **bool** |  |


**Return Value:**

Returns null if resource is not found



---
### ResourceLocator::getResources

Return a list of resources instances.

```php
ResourceLocator::getResources( string uri, bool all = false ): \UserFrosting\UniformResourceLocator\ResourceInterface[]
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | Input URI to be searched (can be a file/path) |
| `all` | **bool** | Whether to return all paths even if they don&#039;t exist. |


**Return Value:**

Array of Resources



---
### ResourceLocator::listResources

List all resources found at a given uri.

```php
ResourceLocator::listResources( string uri, bool all = false, bool sort = true ): \UserFrosting\UniformResourceLocator\ResourceInterface[]
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | Input URI to be searched (can be a uri/path ONLY) |
| `all` | **bool** | If true, all resources will be returned, not only topmost ones |
| `sort` | **bool** | Set to true to sort results alphabetically by absolute path. Set to false to sort by absolute priority, higest location first. Default to true. |


**Return Value:**

The resources list



---
### ResourceLocator::reset

Reset locator by removing all the registered streams and locations.

```php
ResourceLocator::reset(  ): static
```





**Return Value:**





---
### ResourceLocator::isStream

Returns true if uri is resolvable by using locator.

```php
ResourceLocator::isStream( string uri ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | URI to test |


**Return Value:**

True if is resolvable



---
### ResourceLocator::findResource

Find highest priority instance from a resource. Return the path for said resource
For example, if looking for a `test.json` resource, only the top priority
instance of `test.json` found will be returned.

```php
ResourceLocator::findResource( string uri, bool absolute = true, bool all = false ): string|null
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | Input URI to be searched (can be a file or directory) |
| `absolute` | **bool** | Whether to return absolute path. |
| `all` | **bool** | Whether to include all paths, even if they don&#039;t exist. |


**Return Value:**

The resource path, or null if not found resource



---
### ResourceLocator::findResources

Find all instances from a resource. Return an array of paths for said resource
For example, if looking for a `test.json` resource, all instance
of `test.json` found will be listed.

```php
ResourceLocator::findResources( string uri, bool absolute = true, bool all = false ): string[]
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** | Input URI to be searched (can be a file or directory) |
| `absolute` | **bool** | Whether to return absolute path. |
| `all` | **bool** | Whether to return all paths, even if they don&#039;t exist. |


**Return Value:**

An array of all the resources path



---
### ResourceLocator::getStreamBuilder



```php
ResourceLocator::getStreamBuilder(  ): \UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder
```





**Return Value:**





---
### ResourceLocator::getBasePath



```php
ResourceLocator::getBasePath(  ): string
```





**Return Value:**





---
## ResourceStream

The representation of a stream.



* Full name: \UserFrosting\UniformResourceLocator\ResourceStream
* This class implements: \UserFrosting\UniformResourceLocator\ResourceStreamInterface


### ResourceStream::__construct



```php
ResourceStream::__construct( string scheme, string path = null, bool shared = false, bool readonly = false ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |
| `path` | **string** |  |
| `shared` | **bool** |  |
| `readonly` | **bool** |  |


**Return Value:**





---
### ResourceStream::getScheme



```php
ResourceStream::getScheme(  ): string
```





**Return Value:**





---
### ResourceStream::getPath

Path default to scheme when null.

```php
ResourceStream::getPath(  ): string
```





**Return Value:**





---
### ResourceStream::isShared



```php
ResourceStream::isShared(  ): bool
```





**Return Value:**





---
### ResourceStream::isReadonly

Is the stream read only.

```php
ResourceStream::isReadonly(  ): bool
```





**Return Value:**





---
## Stream

Implements Read/Write Streams.



* Full name: \UserFrosting\UniformResourceLocator\StreamWrapper\Stream
* This class implements: \UserFrosting\UniformResourceLocator\StreamWrapper\StreamInterface


### Stream::setLocator



```php
Stream::setLocator( \UserFrosting\UniformResourceLocator\ResourceLocatorInterface locator ): void
```



* This method is **static**.
**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `locator` | **\UserFrosting\UniformResourceLocator\ResourceLocatorInterface** |  |


**Return Value:**





---
### Stream::stream_open

{@inheritDoc}

```php
Stream::stream_open( string uri, string mode, int options, ?string &opened_path ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |
| `mode` | **string** |  |
| `options` | **int** |  |
| `opened_path` | **?string** |  |


**Return Value:**





---
### Stream::stream_close

{@inheritDoc}

```php
Stream::stream_close(  ): void
```





**Return Value:**





---
### Stream::stream_lock

{@inheritDoc}

```php
Stream::stream_lock( int operation ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `operation` | **int** |  |


**Return Value:**





---
### Stream::stream_metadata

{@inheritDoc}

```php
Stream::stream_metadata( string uri, int option, mixed value ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |
| `option` | **int** |  |
| `value` | **mixed** |  |


**Return Value:**





---
### Stream::stream_read

{@inheritDoc}

```php
Stream::stream_read( int count ): string|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `count` | **int** |  |


**Return Value:**





---
### Stream::stream_write

{@inheritDoc}

```php
Stream::stream_write( string data ): int
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `data` | **string** |  |


**Return Value:**





---
### Stream::stream_eof

{@inheritDoc}

```php
Stream::stream_eof(  ): bool
```





**Return Value:**





---
### Stream::stream_seek

{@inheritDoc}

```php
Stream::stream_seek( int offset, int whence = SEEK_SET ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `offset` | **int** |  |
| `whence` | **int** |  |


**Return Value:**





---
### Stream::stream_flush

{@inheritDoc}

```php
Stream::stream_flush(  ): bool
```





**Return Value:**





---
### Stream::stream_tell

{@inheritDoc}

```php
Stream::stream_tell(  ): int
```





**Return Value:**





---
### Stream::stream_stat

{@inheritDoc}

```php
Stream::stream_stat(  ): array|false
```





**Return Value:**





---
### Stream::unlink

{@inheritDoc}

```php
Stream::unlink( string uri ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `uri` | **string** |  |


**Return Value:**





---
### Stream::rename

{@inheritDoc}

```php
Stream::rename( string path_from, string path_to ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path_from` | **string** |  |
| `path_to` | **string** |  |


**Return Value:**





---
### Stream::mkdir

{@inheritDoc}

```php
Stream::mkdir( string path, int mode, int options ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `mode` | **int** |  |
| `options` | **int** |  |


**Return Value:**





---
### Stream::rmdir

{@inheritDoc}

```php
Stream::rmdir( string path, int options ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `options` | **int** |  |


**Return Value:**





---
### Stream::url_stat

{@inheritDoc}

```php
Stream::url_stat( string path, int flags ): array|false
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `flags` | **int** |  |


**Return Value:**





---
### Stream::dir_opendir

{@inheritDoc}

```php
Stream::dir_opendir( string path, int options ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `path` | **string** |  |
| `options` | **int** |  |


**Return Value:**





---
### Stream::dir_readdir

{@inheritDoc}

```php
Stream::dir_readdir(  ): string
```





**Return Value:**





---
### Stream::dir_rewinddir

{@inheritDoc}

```php
Stream::dir_rewinddir(  ): bool
```





**Return Value:**





---
### Stream::dir_closedir

{@inheritDoc}

```php
Stream::dir_closedir(  ): bool
```





**Return Value:**





---
## StreamBuilder

Class StreamBuilder.



* Full name: \UserFrosting\UniformResourceLocator\StreamWrapper\StreamBuilder


### StreamBuilder::__construct

StreamBuilder constructor.

```php
StreamBuilder::__construct( string[] items = [] ): mixed
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `items` | **string[]** | Streams to register (as $scheme =&gt; $handler) |


**Return Value:**





---
### StreamBuilder::add



```php
StreamBuilder::add( string scheme, string handler ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |
| `handler` | **string** |  |


**Return Value:**





---
### StreamBuilder::remove



```php
StreamBuilder::remove( string scheme ): static
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |


**Return Value:**





---
### StreamBuilder::getStreams



```php
StreamBuilder::getStreams(  ): string[]
```





**Return Value:**





---
### StreamBuilder::isStream



```php
StreamBuilder::isStream( string scheme ): bool
```




**Parameters:**

| Parameter | Type | Description |
|-----------|------|-------------|
| `scheme` | **string** |  |


**Return Value:**





---
## StreamNotFoundException

StreamNotFoundException Used when a path is not registered.



* Full name: \UserFrosting\UniformResourceLocator\Exception\StreamNotFoundException
* Parent class: 


