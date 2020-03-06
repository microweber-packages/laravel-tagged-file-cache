<?php

use Orchestra\Testbench\Contracts\TestCase;
use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Cache\TaggableFileCacheServiceProvider;
use MicroweberPackages\Cache\TaggedFileCache;

class TaggableFileStoreTest extends BaseTest
{
    public function testSimple()
    {
        Cache::put('coffe', '3v1', now()->addMinutes(3));

        $this->assertEquals('3v1', Cache::get('coffe'));

    }

    public function testPutWithoutTags()
    {
        Cache::put('firstName', 'Bozhidar', now()->addMinutes(3));
        $this->assertEquals('Bozhidar', Cache::get('firstName'));

        Cache::put('lastName', 'Slaveykov', now()->addMinutes(6));
        $this->assertEquals('Slaveykov', Cache::get('lastName'));

    }

    public function testGetWithoutTags()
    {
        $this->assertEquals('Bozhidar', Cache::get('firstName'));
        $this->assertEquals('Slaveykov', Cache::get('lastName'));
    }

   public function testPutWithTags()
   {
       Cache::tags(['people', 'artists'])->put('firstName', 'Peter', now()->addMinutes(9));

       $this->assertEquals('Peter', Cache::tags('people')->get('firstName'));
       $this->assertEquals('Peter', Cache::tags('artists')->get('firstName'));
       $this->assertEquals(NULL, Cache::tags('wrongTag')->get('firstName'));
   }


    public function testFlush()
    {
        Cache::tags(['people'])->flush();
    }

}