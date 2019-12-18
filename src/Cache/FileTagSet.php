<?php

namespace MicroweberPackages\Cache;

use Illuminate\Cache\TagSet;
use MicroweberPackages\Jobs\FlushTagFromFileCacheJob;

class FileTagSet extends TagSet
{

    protected static $driver = 'tfile';

    /**
     * Get the tag identifier key for a given tag.
     *
     * @param  string $name
     * @return string
     */
    public function tagKey($name)
    {
        return 'cache_tags' . $this->store->separator . preg_replace('/[^\w\s\d\-_~,;\[\]\(\).]/', '~', $name);
    }

    /**
     * Reset the tag and return the new tag identifier.
     *
     * @param  string $name
     * @return string
     */
    public function resetTag($name)
    {
        $oldId = $this->store->get($this->tagKey($name));

        if ($oldId !== false) {
            app('cache')->driver(self::$driver)->flushOldTag($this->getNamespace());
        }

        return parent::resetTag($name);
    }
    
     /**
     * Get a unique namespace that changes when any of the tags are flushed.
     *
     * @return string
     */
    public function getNamespace()
    {
        return md5(implode('_', $this->tagIds()));
    }

}
