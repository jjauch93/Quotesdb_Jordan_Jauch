<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Makes sure category PUT submission contains category and id
    if(!property_exists($data, 'category') || !property_exists($data, 'id')) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        return;
    }

    $category->id = $data->id;
    $category->category = $data->category;

    // Update category
    if($category->update())
        echo json_encode(array('id' => $category->id, 'category' => $category->category));
    else
        echo json_encode(array('message' => 'category_id Not Found'));
?>