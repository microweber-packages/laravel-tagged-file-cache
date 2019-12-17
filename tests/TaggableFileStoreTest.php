<?php

use Orchestra\Testbench\Contracts\TestCase;
use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Cache\TaggableFileCacheServiceProvider;
use MicroweberPackages\Cache\TaggedFileCache;

class TaggableFileStoreTest extends BaseTest
{

    public function testPathGeneratesCorrectPathfoKeyWithoutSeparator()
    {
        $reflectionMethod = new ReflectionMethod(TaggableFileStore::class, 'path');

        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), []);
        $reflectionMethod->setAccessible(true);
        $path = $reflectionMethod->invoke($store, 'foobar');

        $this->assertTrue(Str::contains($path, storage_path('framework/cache')));
        $this->assertTrue(str_replace(storage_path('framework/cache'), '', $path) === '/88/43/8843d7f92416211de9ebb963ff4ce28125932878');

    }

    public function testPathGeneratesCorrectPathforKeyWithSeparator()
    {
        $reflectionMethod = new ReflectionMethod(TaggableFileStore::class, 'path');

        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), []);
        $reflectionMethod->setAccessible(true);
        $path = $reflectionMethod->invoke($store, 'boofar~#~foobar');

        $this->assertTrue(Str::contains($path, storage_path('framework/cache')));
        $this->assertTrue(str_replace(storage_path('framework/cache'), '', $path) === '/boofar/88/43/8843d7f92416211de9ebb963ff4ce28125932878');

    }

    public function testPathGeneratesCorrectPathforKeyWithCustomSeparator()
    {
        $reflectionMethod = new ReflectionMethod(TaggableFileStore::class, 'path');

        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), ['separator' => '~|~']);
        $reflectionMethod->setAccessible(true);
        $path = $reflectionMethod->invoke($store, 'boofar~|~foobar');

        $this->assertTrue(Str::contains($path, storage_path('framework/cache')));
        $this->assertTrue(str_replace(storage_path('framework/cache'), '', $path) === '/boofar/88/43/8843d7f92416211de9ebb963ff4ce28125932878');

    }

    public function testTagsReturnsTaggedFileCache()
    {
        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), []);

        $cache = $store->tags(['abc', 'def']);

        $this->assertInstanceOf(TaggedFileCache::class, $cache);
    }

    public function testFlushOldTagDeletesTagFolders()
    {
        $filesMock = Mockery::mock(new Illuminate\Filesystem\Filesystem());
        $store = new TaggableFileStore($filesMock, '/', []);

        $filesMock->shouldReceive('directories')->with('/')->andReturn([
            'test/foobar',
            'foobar',
            'testfoobar',
            'testfoobartest',
            'test/testfoobartest'
        ]);

        $filesMock->shouldReceive('deleteDirectory')->with('test/foobar')->once();
        $filesMock->shouldReceive('deleteDirectory')->with('foobar')->once();
        $filesMock->shouldReceive('deleteDirectory')->with('testfoobar')->once();
        $filesMock->shouldReceive('deleteDirectory')->with('testfoobartest')->once();
        $filesMock->shouldReceive('deleteDirectory')->with('test/testfoobartest')->once();
        $store->flushOldTag('foobar');

    }

    public function testFlushOldTagDoesNotDeletesOtherFolders()
    {
        $filesMock = Mockery::mock(new Illuminate\Filesystem\Filesystem());
        $store = new TaggableFileStore($filesMock, '/', []);

        $filesMock->shouldReceive('directories')->with('/')->andReturn([
            'test/foobar/foo',
            'foobar/test',
            'test'
        ]);

        $filesMock->shouldNotReceive('deleteDirectory')->with('test/foobar/foo');
        $filesMock->shouldNotReceive('deleteDirectory')->with('foobar/test');
        $filesMock->shouldNotReceive('deleteDirectory')->with('test');

        $store->flushOldTag('foobar');

    }
}