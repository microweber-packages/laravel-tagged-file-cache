# Laravel Taggable File Cache
This package provides a custom file [cache driver](https://laravel.com/docs/5.1/cache#adding-custom-cache-drivers) that supports [Cache Tags](https://laravel.com/docs/5.1/cache#cache-tags) for Laravel 5.1 or Lumen 5.2+.

## Usage
This product is publicly available under the terms of the MIT license included in this repository. Please refer to the current [brand guidelines](https://www.kent.ac.uk/brand) for use of the existing brand.

## Installation and Requirements
First, you'll need to require the package with Composer:
```
composer require microweber-packages/laravel-tagged-file-cache
```

Then, update `config/app.php` by adding an entry for the service provider.
```
'providers' => [
    // ...
    MicroweberPackages\Cache\TaggableFileCacheServiceProvider::class
];
```
Finally, add the necessary config to  `config\cache.php`. 

```
'default' => env('CACHE_DRIVER', 'tfile'),

'stores' => [

		'tfile' => [
			'driver' => 'tfile',
			'path'   => storage_path('framework/cache')
		],
		// ...
],
```

## Optional Configuration
There are some optional config options available in the store definition above:

`queue` :  accepts the string name of a queue to use for [tag clean up](#tag-cleanup), will use the default queue if omitted.
`separator` : defines the separator character or sequence to be used internally, this should be chosen to **never** collide with a key value. defaults to `~#~` if omitted.


## Tag Cleanup
To offset the work of cleaning up cache entries when a tag is flushed this task is added as a Job
and queued using laravel's inbuilt [queueing](https://laravel.com/docs/5.1/queues).
Note: laravel's default queue driver is `sync` which will result in the job being executed synchronously,
it is strongly advised you use an alternate queue driver with appropriate workers to offset this work
if you wish to use this cache driver. 

