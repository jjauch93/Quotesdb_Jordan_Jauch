<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow-Methods, Authorization, X-Requested-With');

    require '../../config/Database.php';
    require '../../models/Author.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate author object
    $author = new Author($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Makes sure author DELETE submission contains id
    if(!isset($data->id)) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        return;
    }

    $author->id = $data->id;

    // Delete author
    if($author->delete())
        echo json_encode(array("id" => $author->id));
    else
        echo json_encode(array('message' => 'author_id Not Found'));
?>