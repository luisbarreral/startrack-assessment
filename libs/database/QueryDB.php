<?php
$currentDirectory = dirname(__FILE__);
$upperDirectory = dirname($currentDirectory);
include_once "MyDB.php";
include_once $upperDirectory . '/' ."Query.php";
include_once $upperDirectory . '/' ."Result.php";

class QueryDB
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
            $sql = "CREATE TABLE IF NOT EXISTS QUERY (
                id INTEGER PRIMARY KEY, 
                name TEXT, 
                created_at TEXT,
                updated_at TEXT)";
            $this->my_db->exec($sql);
        } catch (Exception $th) {

        }
    }

    /**
     * @param Query $query
     * @return Result
     */
    function insertQuery($query)
    {
        $result = new Result();
        try {
            $created_at = date(self::FORMAT);
            $name = $query->getName();
            $sql = "INSERT INTO QUERY (name, created_at, updated_at)
                    VALUES ('$name', '$created_at', '$created_at')";
            $inserted = $this->my_db->exec($sql);

            if ($this->my_db->last_error != null) {
                $result->setState(false);
                $result->setMessage($this->my_db->last_error);
            }else{
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

    function getQueryFromName($name)
    {
        $result = new Result();
        try {

        } catch (Exception $ex) {

        }
        return $result;
    }
}

?>