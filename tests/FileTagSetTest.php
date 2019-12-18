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
            'separator' => '-bobi-bobi-',
        ]);
        $tagSet = new FileTagSet($store, ['foobar']);

        $this->assertEquals('cache_tags-bobi-bobi-foobar', $tagSet->tagKey('foobar'));
    }

}