<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    require '../../config/Database.php';
    require '../../models/Quote.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Quote query
    $result = $quote->read();
    // Get row count
    $num = $result->rowCount();

    // Check if there are quotes
    if($num > 0) {
        // Quote array
        $quotes_arr = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $quote_item = array(
                'id' => $id,
                'quote' => $quote,
                'author' => $author,
                'category' => $category
            );

            // Push data
            array_push($quotes_arr, $quote_item);
        }

        // Turn to JSON and output
        echo json_encode($quotes_arr);
    } else
        // No quotes
        echo json_encode(array('message' => 'No Quotes Found'));
?>