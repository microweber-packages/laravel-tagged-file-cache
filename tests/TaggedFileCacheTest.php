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

		$this->assertEquals('5df89be107546866808177~#~test',$cache->taggedItemKey('test'));

		$cache = new TaggedFileCache($store, new FileTagSet($store, ['boofar']));

		$this->assertEquals('5df89e0ca9ce6114526348~#~arg',$cache->taggedItemKey('arg'));
	}

}