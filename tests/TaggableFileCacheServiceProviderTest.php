<?php

use MicroweberPackages\Cache\TaggableFileStore;

class TaggableFileCacheServiceProviderTest extends BaseTest
{

	public function testCacheIsTaggableFileCacheWhenUsing(){

		$this->assertInstanceOf(TaggableFileStore::class,app('cache')->store()->getStore());
	}

    public function testResponse()
    {

        //Cache::tags(['people', 'artists'])->put('John', 'John-2', 5);
        //Cache::tags(['people', 'authors'])->put('Anne', 'Anne-2', 5);

        //$john = Cache::tags(['people', 'artists'])->get('John');
        // $anne = Cache::tags(['people', 'authors'])->get('Anne');




        //var_dump($john);
        // var_dump($anne);
       // die();
    }

}