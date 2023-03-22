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

    // Category query
    $result = $category->read();
    // Get row count
    $num = $result->rowCount();

    // Check if there are categories
    if($num > 0) {
        // Category array
        $categories_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // Push data
            array_push($categories_arr, $category_item);
        }

        // Turn to JSON and output
        echo json_encode($categories_arr);
    } else
        // No categories exist
        echo json_encode(array('message' => 'No Categories Found'));
?>