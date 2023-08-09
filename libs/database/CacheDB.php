<?php
$currentDirectory = dirname(__FILE__);
$upperDirectory = dirname($currentDirectory);
include_once "MyDB.php";
include_once $upperDirectory . '/' . "Cache.php";
include_once $upperDirectory . '/' . "Result.php";

class CacheDB
{
    private $my_db;
    private const QUERY = "query",
        FORMAT = "Y-m-d H:i:s";

    public function __construct()
    {
        date_default_timezone_set("America/Guatemala");
        $this->my_db = new MyDB();
        $this->createTable();
    }

    /**
     * @return mixed
     */
    private function createTable()
    {
        try {
            $sql = "CREATE TABLE IF NOT EXISTS CACHE (
                key TEXT, 
                data TEXT,
                time TEXT)";
            $this->my_db->exec($sql);
        } catch (Exception $th) {

        }
    }

    public function insertCache(Cache $cache)
    {
        $result = new Result();

        try {
            $key = $cache->getKey();
            $data = $cache->getData();
            $time = time();
            $sql = "INSERT INTO CACHE (key, data, time)
                    VALUES ('$key', '$data', '$time')";
            $inserted = $this->my_db->exec($sql);

            if ($this->my_db->last_error != null) {
                $result->setState(false);
                $result->setMessage($this->my_db->last_error);
            } else {
                $result->setState(true);
                $result->setMessage($inserted . " lines inserted");
                $result->setData($inserted);
            }

        } catch (Exception $ex) {
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }

    public function updateCache(Cache $cache)
    {
        $result = new Result();

        try {
            $key = $cache->getKey();
            $data = $cache->getData();
            $time = time();
            $sql = "UPDATE CACHE SET data = '$data', time = '$time'
                    WHERE key = '$key'";
            $updated = $this->my_db->exec($sql);

            if ($this->my_db->last_error != null) {
                $result->setState(false);
                $result->setMessage($this->my_db->last_error);
            } else {
                $result->setState(true);
                $result->setMessage($updated . " lines updated");
                $result->setData($updated);
            }

        } catch (Exception $ex) {
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }

    public function getCacheFromKey($key)
    {
        $result = new Result();

        try {
            $sql = "SELECT * FROM CACHE where key = '$key'";
            $data_result = $this->my_db->query($sql);

            if ($this->my_db->last_error != null) {
                $result->setState(false);
                $result->setMessage($this->my_db->last_error);
            } else {
                $result->setState(true);
                $result->setMessage("DATA OBTAINED.");
                $result->setData($data_result);
            }

        } catch (Exception $ex) {
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }
}

?>