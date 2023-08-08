<?php

require_once "Query.php";
require_once "Request.php";
require_once "Result.php";
require_once "database/QueryDB.php";
require_once "CacheHandler.php";

class Caller
{
    private const URL = "https://api.stackexchange.com/2.3/search?";

    /**
     * @param string $name
     * @param string $page_size
     * @param string $page
     * @return Result
     */
    function call($page, $page_size, $name)
    {
        $result = new Result();

        try {
            $name = strtolower($name);
            $query = new Query($name);
            $query_db = new QueryDB();
            $operation = $query_db->createQuery($query);

            if ($operation->getState()) {
                $request = new Request();
                $params = "page=$page&pagesize=$page_size&intitle=$name&site=stackoverflow";
                $url = self::URL . $params;
                $response = $request->get($url);

                if ($response->getState()) {                    
                    $data = $response->getData();
                    $items = $data['items'];
                    
                    foreach ($items as $item) {
                        # code...
                    }

                }else{
                    $result->setState(false);
                    $result->setMessage($response->getMessage());
                }

            } else {
                $result->setState(false);
                $result->setMessage($operation->getMessage());
            }

        } catch (Exception $ex) {
            $result->setState(false);
            $result->setMessage($ex->getMessage());
        }

        return $result;
    }
}

?>