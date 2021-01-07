<?php

/**
 * post json
 * @param $url
 * @param $params
 * @param int $timeout
 * @return mixed
 */
function curlJsonPost($url, $params, $timeout = 10)
{
    $start_time = time();
    $data_str = json_encode($params);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_str),
    ));

    $response = curl_exec($ch);
    curl_close($ch);
    unset($ch);
    $end_time = time();
    write_log("CURL_HTTP_JSON_POST\turl: " . $url . "\tend_at: " . date('Y-m-d H:i:s', $end_time) . "\ttime_used: " . ($end_time - $start_time));
    write_log("CURL_HTTP_JSON_POST\tresponse: " . $response);
    return $response;
}