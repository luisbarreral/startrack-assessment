<?php

include_once "Result.php";
include_once "Cache.php";
include_once "database/CacheDB.php";

class CacheHandler
{
    private $cache_db;

    function __construct()
    {
        date_default_timezone_set("America/Guatemala");
        $this->cache_db = new CacheDB();
    }

    function setCacheData($key, $data)
    {
        $result = null;

        try {
            $cache = new Cache($key, $data);
            $cache_exist = $this->cache_db->getCacheFromKey($cache->getKey());

            if ($cache_exist->getState() && sizeof($cache_exist->getData()) > 0) {
                $result = $this->cache_db->updateCache($cache);
            } else {
                $result = $this->cache_db->insertCache($cache);
            }
        } catch (Exception $ex) {
            $result = new Result();
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }

    function getCachedData($key)
    {
        $result = new Result();

        try {
            $cache_exist = $this->cache_db->getCacheFromKey($key);
            $data = $cache_exist->getData();
            
            if ($cache_exist->getState() && sizeof($data) > 0 && (time() - $data[0]["time"]) < 60) {
                $result->setData($data[0]['data']);
                $result->setState(true);
                $result->setMessage("DATA FOUND.");
            }else{
                $result->setState(false);
                $result->setMessage("DATA NOT FOUND.");
            }

        } catch (Exception $ex) {
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }


}

?>