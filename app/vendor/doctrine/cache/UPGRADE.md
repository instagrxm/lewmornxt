<<<<<<< HEAD
# Upgrade to 1.4

## Minor BC Break: `Doctrine\Common\Cache\FileCache#$extension` is now `private`.

If you need to override the value of `Doctrine\Common\Cache\FileCache#$extension`, then use the
second parameter of `Doctrine\Common\Cache\FileCache#__construct()` instead of overriding
the property in your own implementation.

## Minor BC Break: file based caches paths changed

`Doctrine\Common\Cache\FileCache`, `Doctrine\Common\Cache\PhpFileCache` and
`Doctrine\Common\Cache\FilesystemCache` are using a different cache paths structure.

If you rely on warmed up caches for deployments, consider that caches generated
with `doctrine/cache` `<1.4` are not compatible with the new directory structure,
and will be ignored.
=======
# Upgrade to 1.4

## Minor BC Break: `Doctrine\Common\Cache\FileCache#$extension` is now `private`.

If you need to override the value of `Doctrine\Common\Cache\FileCache#$extension`, then use the
second parameter of `Doctrine\Common\Cache\FileCache#__construct()` instead of overriding
the property in your own implementation.

## Minor BC Break: file based caches paths changed

`Doctrine\Common\Cache\FileCache`, `Doctrine\Common\Cache\PhpFileCache` and
`Doctrine\Common\Cache\FilesystemCache` are using a different cache paths structure.

If you rely on warmed up caches for deployments, consider that caches generated
with `doctrine/cache` `<1.4` are not compatible with the new directory structure,
and will be ignored.
>>>>>>> 93406d403370e91633bdbb3849fac6e7ddd3dc5f
