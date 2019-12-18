<?php

use MicroweberPackages\Cache\TaggableFileStore;
use MicroweberPackages\Jobs\FlushTagFromFileCacheJob;
use MicroweberPackages\Cache\FileTagSet;
use Illuminate\Contracts\Bus\Dispatcher;

class FileTagSetTest extends BaseTest
{

    public function testTagKeyGeneratesPrefixedKey()
    {
        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), []);
        $tagSet = new FileTagSet($store, ['foobar']);

        $this->assertEquals('cache_tags---foobar', $tagSet->tagKey('foobar'));
    }


    public function testTagKeyGeneratesPrefixedKeywithCustomSeparator()
    {
        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), [
            'separator' => '---',
        ]);
        $tagSet = new FileTagSet($store, ['foobar']);

        $this->assertEquals('cache_tags---foobar', $tagSet->tagKey('foobar'));
    }

    public function testResetTagDispatchesJob()
    {
        $store = new TaggableFileStore($this->app['files'], storage_path('framework/cache'), []);
        $tagSet = new FileTagSet($store, ['testtag']);

        $dispatcher = Mockery::mock(app(Dispatcher::class));
        $dispatcher->shouldReceive('dispatch')->with(Mockery::type(FlushTagFromFileCacheJob::class))->once();

        $this->app->instance(Dispatcher::class, $dispatcher);

        $tagSet->resetTag('testtag');
    }

}