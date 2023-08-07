<?php
include_once "MyDB.php";
include_once "../Query.php";
include_once "../Result.php";

class QueryDB
{
    private $my_db;
    private const QUERY = "query",
    FORMAT = "yyyy-mm-dd H:i:s";    

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
            $sql = "CREATE TABLE IF NOT EXISTS self::QUERY (
                id INTEGER PRIMARY KEY, 
                name TEXT, 
                created_at TEXT,
                updated_at TEXT)";
            $this->my_db->exec($sql);
        } catch (Exception $th) {

        }
    }

    function createQuery(Query $query)
    {
        $result = new Result();
        try{            
            $created_at = date(self::FORMAT);
            $sql = "INSERT INTO self::QUERY (name, created_at, updated_at)
                    VALUES ($query->getName(), $created_at, $created_at)";
            $inserted = $this->my_db->exec($sql);

            if ($this->my_db->last_error != null) {
                $result->setState(false);
                $result->setMessage($this->my_db->last_error);
            } 

            $result->setState(true);
            $result->setMessage($inserted . "lines inserted");

        } catch(Exception $ex){
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }
        return $result;
    }
}

?>