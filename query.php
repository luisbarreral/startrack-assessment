<?php
require_once "libs/Response.php";
require_once "libs/Query.php";
require_once "libs/QueryDB.php";
header('Content-Type: application/json');
function query()
{
    $response = new Response();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (!array_key_exists('query', $_POST)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: query parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $query = $_POST['query'];

        if (!array_key_exists('init_date', $_POST)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: init_date parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $init_date = $_POST['init_date'];

        if (!array_key_exists('final_date', $_POST)) {
            http_response_code(500);
            $response->setCode(500);
            $response->setMessage("ERROR: init_final_datedate parameter not found.");
            $response->setStatus(false);
            echo json_encode($response, JSON_PRETTY_PRINT);
            return;
        }

        $final_date = $_POST['final_date'];
        
        $result = new Result();

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

query();
?>