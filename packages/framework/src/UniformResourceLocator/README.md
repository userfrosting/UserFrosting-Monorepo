# Uniform Resource Locator

The _Uniform Resource Locator_ module handles resource aggregation and stream wrapper related tasks for [UserFrosting](https://github.com/userfrosting/UserFrosting).

# Problem to Solve

It's easy to find files when they are located in a single place. It's another task when looking for files scattered across multiple directory. Step into the world of package and dependencies and the nightmare begins.

![](docs/Graph.png)

It's like trying to find someone in a one story house vs. a 25 stories office building when you don't know on which floor the person is. This package goal is to help you locate things in that office building without having to search floor by floor each time. In other words, it is a way of aggregating many search paths together.

# Documentation

* [Main Documentation](docs/)
* [API docs](docs/api/)
* [Working example / tutorial](docs/Example.md).

## Building doc

First, you need to install phpDocumentor. There are multiple options how to install it, one of them is using the PHAR:

```bash
$ wget https://phpdoc.org/phpDocumentor.phar
```

Read more about [installation of phpDocumentor](https://phpdoc.org/)

Once installed, run phpDocumentator, using UniformResourceLocator config file.

```
php phpDocumentor.phar -c src/UniformResourceLocator/phpdoc.xml 
```

# References

- [The Power of Uniform Resource Location in PHP](https://web.archive.org/web/20131116092917/http://webmozarts.com/2013/06/19/the-power-of-uniform-resource-location-in-php/)
- [When we should we use stream wrapper and socket in PHP?](https://stackoverflow.com/questions/11222498/when-we-should-we-use-stream-wrapper-and-socket-in-php)
- [rockettheme/toolbox](https://github.com/rockettheme/toolbox)
