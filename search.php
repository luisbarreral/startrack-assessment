<?php
header('Content-Type: application/json');
require_once "libs/Response.php";
require_once "libs/Caller.php";
function search()
{
    $response = new Response();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $page = '';
        $page_size = '';
        $query = '';

        if (!array_key_exists('page', $_GET)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: page parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $page = $_GET['page'];

        if (!array_key_exists('size', $_GET)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: size parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $page_size = $_GET['size'];

        if (!array_key_exists('query', $_GET)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: query parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $query = $_GET['query'];

        $caller = new Caller();
        $result = $caller->call($page, $page_size, $query);

        if($result->getState()){
            $response->setCode(200);
        }else{
            $response->setCode(500);
        }

        $response->setData($result->getData());
        $response->setMessage($result->getMessage());
        $response->setStatus($response->getStatus());

        echo json_encode($response, JSON_PRETTY_PRINT);
        return;

    } else {        
        http_response_code(405);
        $response->setCode(405);
        $response->setMessage("ERROR: Method Not Allowed.");
        $response->setStatus(false);
        echo json_encode($response, JSON_PRETTY_PRINT);
        return;
    }
    
}

search();
?>