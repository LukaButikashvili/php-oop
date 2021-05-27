<?php 
    
require_once 'core/router/router_matcher.php';

require_once './lib/files/ResponseFactory.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

//check if file exist in project
register_handlers('routes/handlers.php');

//get data name which user requests
$dataName = explode('php-oop', $_SERVER['REQUEST_URI'])[1];

//change content type config
$accept_header = $_SERVER['HTTP_ACCEPT'];
changeContentConfigType($accept_header);

//get Data of specific people
$result = matchRoute($dataName, 'routes/routes.json');

//create Response
$request = ResponseFactory::createResponse($result);

$request->send_response();

function changeContentConfigType(string $accept_header) {
    $CONTENT_TYPE_PATH = 'core/config/config.json';
    $DEFAULT_CONTENT_TYPE = 'text/html';

    $get_content = json_decode(file_get_contents($CONTENT_TYPE_PATH), true);

    $split_string = explode('/', $accept_header);

    if( count($split_string) === 2) {
        $get_content['content']['type'] = $accept_header;
        $array_to_json = json_encode($get_content);
        file_put_contents($CONTENT_TYPE_PATH, $array_to_json);
    } else {
        $get_content['content']['type'] = $DEFAULT_CONTENT_TYPE;
        $array_to_json = json_encode($get_content);
        file_put_contents($CONTENT_TYPE_PATH, $array_to_json);
    }
}