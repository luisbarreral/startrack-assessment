<?php
class CacheHandler
{
    private $cache;

    function __construct()
    {
        $this->cache = new Memcached();
    }

    function setCacheData($key, $data)
    {
        $this->cache->add('key', 'value', 60); // 1 minute
    }

    function getCachedData($key)
    {
        $data = $this->cache->get($key);

        if ($data === false) {
            return null;
        }

        return $data;
    }
}

?>