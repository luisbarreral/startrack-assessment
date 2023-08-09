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
            $operation = $query_db->insertQuery($query);

            if ($operation->getState()) {
                $key = $this->createCacheKey($page, $page_size, $name);
                $cache_handler = new CacheHandler();
                $cached_data = $cache_handler->getCachedData($key);

                if ($cached_data->getState()) {
                    $result->setState(true);
                    $data = json_decode($cached_data->getData(), true);
                    $result->setData($data);
                    $result->setMessage("SUCCESS: posts found.");
                } else {
                    $result = $this->makeRequest($page, $page_size, $name);

                    if ($result->getState()) {
                        $json_data = json_encode($result->getData());
                        $cache_handler->setCacheData($key, $json_data);
                    }

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

    private function createCacheKey($page, $page_size, $name)
    {
        return $page . "_" . $page_size . "_" . $name;
    }

    private function makeRequest($page, $page_size, $name)
    {
        $result = new Result();
        $request = new Request();
        $name = urlencode($name);
        $params = "page=$page&pagesize=$page_size&intitle=$name&site=stackoverflow";
        $url = self::URL . $params;
        $response = $request->get($url);

        if ($response->getState()) {
            $data = $response->getData();
            $items = $data['items'];
            $posts_data = array();

            foreach ($items as $item) {
                $post = array(
                    'title' => $item['title'],
                    'answer_count' => $item['answer_count'],
                    'username' => $item['owner']['display_name'],
                    'profile_picture_url' => $item['owner']['profile_image']
                );
                $posts_data[] = $post;
            }

            $result->setState(true);
            $result->setData($posts_data);
            $result->setMessage("SUCCESS: posts found.");
        } else {
            $result->setState(false);
            $result->setMessage($response->getMessage());
        }
        return $result;
    }
}