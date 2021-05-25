<?php 
    
require_once './lib/files/ResponseFactory.php';

//$accept_header = 'application/json';
//$_SERVER['REQUEST_URI'] - gvadzlevs paths localhostidan

$request = ResponseFactory::createResponse('teachers');

$request->send_response();
