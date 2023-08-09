<?php
require_once "libs/Response.php";
require_once "libs/database/QueryDB.php";
require_once "libs/CacheHandler.php";

header('Content-Type: application/json');

function query()
{
    $response = new Response();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $post = json_decode(file_get_contents('php://input'), true);

        if ($post != null) {

            if (!array_key_exists('query', $post)) {
                http_response_code(500);
                $response->setCode(500);
                $response->setMessage("ERROR: query parameter not found.");
                $response->setStatus(false);
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            $query = $post['query'];
            $query = strtolower($query);

            if (!array_key_exists('init_date', $post)) {
                http_response_code(500);
                $response->setCode(500);
                $response->setMessage("ERROR: init_date parameter not found.");
                $response->setStatus(false);
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            $init_date = $post['init_date'];           

            if (!strtotime($init_date)) {
                http_response_code(500);
                $response->setCode(500);
                $response->setMessage("ERROR: init_date is not a valid date time.");
                $response->setStatus(false);
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            if (!array_key_exists('final_date', $post)) {
                http_response_code(500);
                $response->setCode(500);
                $response->setMessage("ERROR: init_final_datedate parameter not found.");
                $response->setStatus(false);
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            $final_date = $post['final_date'];            

            if (!strtotime($final_date)) {
                http_response_code(500);
                $response->setCode(500);
                $response->setMessage("ERROR: final_date is not a valid date.");
                $response->setStatus(false);
                echo json_encode($response, JSON_PRETTY_PRINT);
                return;
            }

            $key = $query . "_" . $init_date . "_" . $final_date;
            $cache_handler = new CacheHandler();
            $cached_data = $cache_handler->getCachedData($key);

            if ($cached_data->getState()) {
                $response->setCode(200);
                $data = json_decode($cached_data->getData(), true);
                $response->setData($data);
                $response->setMessage("DATA OBTAINED.");
            } else {
                $query_db = new QueryDB();
                $query_data = $query_db->getQueryFromName($query, $init_date, $final_date);
    
                if ($query_data->getState()) {
                    $response->setCode(200);

                    $data_rows = $query_data->getData();
                    $final_data = array();

                    foreach ($data_rows as $row) {
                        $clean_data = array(
                            'query' => $row['name'],
                            'date_time' => $row['created_at']
                        );
                        $final_data[] = $clean_data;    
                    }

                    $result = array(
                        'frequency' => sizeof($query_data->getData()),
                        'data' => $final_data
                    );
                    
                    $json_data = json_encode($result);
                    $cache_handler->setCacheData($key, $json_data);
                    $response->setData($result);
                    $response->setMessage($query_data->getMessage());
                } else {
                    $response->setData(null);
                    $response->setMessage($query_data->getMessage());
                }
    
                $response->setStatus($query_data->getState());               
            }
           
        } else {
            $response->setCode(500);
            $response->setMessage("ERROR: final_date is not a valid date.");
            $response->setStatus(false);
        }

        echo json_encode($response, JSON_PRETTY_PRINT);
        return;
    } else {
        http_response_code(500);
        $response->setCode(500);
        $response->setMessage("ERROR: body is not a valid json.");
        $response->setStatus(false);
        echo json_encode($response, JSON_PRETTY_PRINT);
        return;
    }

}

query();
?>