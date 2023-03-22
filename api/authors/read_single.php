<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require '../../config/Database.php';
    require '../../models/Author.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get id from url
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get author
    $author->read_single();

    if($author->author) {
        // Create array
        $author_arr = array(
            'id' => $author->id,
            'author' => $author->author
        );

        // Make JSON
        print_r(json_encode($author_arr));
    } else
        print_r(json_encode(array('message' => 'author_id Not Found')));
?>