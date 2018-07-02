File System Cache Service
===========
Used to get and set cache, from the local filesystem.
Easy to use and to setup

First, configure your cache parameters

``` yaml
# path/to/env/parameters.yml
toolbox:
    fs_system_cache_path: "%kernel.root_dir%/../../var/cache/toolboxCache/" #Path where cache files will be stored
    fs_system_cache_path_chmod: "06644" #Default cache path chmod
    fs_system_cache_path_default_ttl: 3600 #Default cache time
```

Now you can use the get() and set() methods from the service to handle your cache, ex :

``` php
// [...]

class MyController extends Controller
{
    public function myAction()
    {
      $datas = [/*...*/]
      $cacheKey = "my_cache_key";
      $ttl = 3600;

      $this->get('cn_toolbox.cache.filesystem')->set($cacheKey, $ttl);
      // [...]
      $this->get('cn_toolbox.cache.filesystem')->get($cacheKey);
    }
```

If the TTL is passed, the get() method will return null instead of the cache value.
