<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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

    // Makes sure category POST submission contains category
    if(property_exists($data, 'category')) {
        $category->category = $data->category;

        // Create category
        $category->create();
        echo json_encode(array('id' => $db->lastInsertId(), 'category' => $category->category));
    } else
        echo json_encode(array('message' => 'Missing Required Parameters'));
?>