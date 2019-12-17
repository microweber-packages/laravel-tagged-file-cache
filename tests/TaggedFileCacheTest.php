<?php

use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Cache\TaggedFileCache;
use MicroweberPackages\Cache\FileTagSet;

class TaggedFileCacheTest extends BaseTest
{

	public function testItemKeyCallsTaggedItemKey(){

		$store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'),[]);
		$cache = new TaggedFileCache($store, new FileTagSet($store, ['foobar']));

		$mock = Mockery::mock($cache);

		$mock->shouldReceive('taggedItemKey')->with('test');

		$mock->itemKey('test');
	}

	public function testItemKeyReturnsTaggedItemKey(){

		$store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'),[]);
		$cache = new TaggedFileCache($store, new FileTagSet($store, ['foobar']));

		$mock = Mockery::mock($cache);

		$mock->shouldReceive('taggedItemKey')->with('test')->andReturn('boofar');

		$this->assertEquals('boofar',$mock->itemKey('test'));
	}

	public function testTaggedItemKeyGeneratesCorrectlyNamespacedKey(){

		$store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'),[]);
		$cache = new TaggedFileCache($store, new FileTagSet($store, ['foobar']));

		$this->assertEquals('5df8a6a5ebdb5350700074~#~test',$cache->taggedItemKey('test'));

		$cache = new TaggedFileCache($store, new FileTagSet($store, ['boofar']));

		$this->assertEquals('5df8a7446f9c6865545960~#~arg',$cache->taggedItemKey('arg'));
	}

}