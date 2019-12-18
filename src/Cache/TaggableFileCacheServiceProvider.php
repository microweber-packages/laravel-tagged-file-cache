<?php

namespace MicroweberPackages\Cache;

use Illuminate\Support\ServiceProvider;

class TaggableFileCacheServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('cache')->extend('tfile', function ($app, $config) {

            $locale = app()->getLocale();
            if ($locale) {
                $folder = app()->environment() . '-' . $locale . DIRECTORY_SEPARATOR;
            } else {
                $folder = app()->environment() . DIRECTORY_SEPARATOR;
            }

            $configPath = $config['path'] . DIRECTORY_SEPARATOR . $folder;

            $store = new TaggableFileStore($this->app['files'], $configPath, $config);

            return app('cache')->repository($store);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
