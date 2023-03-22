<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Author query
    $result = $author->read();
    // Get row count
    $num = $result->rowCount();

    // Check if there are authors
    if($num > 0) {
        // Author array
        $authors_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $author_item = array(
                'id' => $id,
                'author' => $author
            );

            // Push data
            array_push($authors_arr, $author_item);
        }

        // Turn to JSON and output
        echo json_encode($authors_arr);
    } else
        // No author exist
        echo json_encode(array('message' => 'No Authors Found'));
?>