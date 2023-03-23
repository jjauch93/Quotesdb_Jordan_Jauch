<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

    $uri = $_SERVER['REQUEST_URI'];

    if ($method === 'POST')
        require('create.php');

    else if ($method === 'PUT')
        require('update.php');

    else if ($method === 'DELETE')
        require('delete.php');
    
    else if ($method === 'GET') {
        // Checking url if id is set
        if (parse_url($uri, PHP_URL_QUERY)){
            require('read_single.php');
        } else {
            require('read.php');
        }
    }
?>