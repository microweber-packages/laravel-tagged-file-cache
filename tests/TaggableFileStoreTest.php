<?php

use Orchestra\Testbench\Contracts\TestCase;
use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Cache\TaggableFileCacheServiceProvider;
use MicroweberPackages\Cache\TaggedFileCache;

class TaggableFileStoreTest extends BaseTest
{

    public function testSimplePut()
    {
        Cache::put('Bozhidar', 'firstName', now()->addMinutes(10));


        var_dump(Cache::get('firstName'));

    }

}