<?php

use Orchestra\Testbench\Contracts\TestCase;
use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Cache\TaggableFileCacheServiceProvider;
use MicroweberPackages\Cache\TaggedFileCache;

class TaggableFileStoreTest extends BaseTest
{

    public function testSimple()
    {
        Cache::put('coffe', '3v1');
        $this->assertEquals('3v1', Cache::get('coffe'));

    }

    public function testPutWithoutTags()
    {
        Cache::put('firstName', 'Bozhidar', now()->addMinutes(10));
        $this->assertEquals('Bozhidar', Cache::get('firstName'));

        Cache::put('lastName', 'Slaveykov', now()->addMinutes(10));
        $this->assertEquals('Slaveykov', Cache::get('lastName'));

    }

    public function testGetWithoutTags()
    {
        $this->assertEquals('Bozhidar', Cache::get('firstName'));
        $this->assertEquals('Slaveykov', Cache::get('lastName'));
    }

    public function testPutTags()
    {


    }

}