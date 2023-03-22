<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate category object
    $category = new Category($db);

    // Get id from url
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get category
    $category->read_single();

    if($category->category) {
        // Create array
        $category_arr = array(
            'id' => $category->id,
            'category' => $category->category
        );

        // Make JSON
        print_r(json_encode($category_arr));
    } else
        print_r(json_encode(array('message' => 'category_id Not Found')));
?>