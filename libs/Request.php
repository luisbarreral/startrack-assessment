<?php
include_once "Result.php";
class Request
{
    function __construct()
    {
        date_default_timezone_set("America/Guatemala");
    }

    function get($url, $headers = [])
    {
        $curl = curl_init();

        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $headers
            )
        );

        $response = curl_exec($curl);
        $response_info = curl_getinfo($curl);        

        $res = new Result();
        if ($response_info['http_code'] >= 200 && $response_info['http_code'] <= 299) {
            $res->setData(json_decode($response, true));
            $res->setState(true);
        } else {
            $res->setState(false);
            $res->setMessage("ERROR: " . curl_error($curl));
        }

        curl_close($curl);
        return $res;
    }
}

?>