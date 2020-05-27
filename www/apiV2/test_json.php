<?php

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    error_log('Request method must be POST!');
}
 
//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    error_log('Content type must be: application/json');
}
 
//Receive the RAW post data.
$content = trim(file_get_contents("php://input"), true);
 //echo 'decoded coso desde test: '.var_dump($content);
//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

//$_POST = json_decode(file_get_contents('php://input'), true);

//var_dump($decoded);

echo '<br>Precio '.$decoded['Precio'];
//If json_decode failed, the JSON is invalid.
if(!is_array($decoded)){
    error_log('Received content contained invalid JSON!');
}
//error_log(var_dump($decoded));
?>