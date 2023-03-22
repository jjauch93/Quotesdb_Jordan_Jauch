<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
    Access-Control-Allow-Methods, Authorization, X-Requested-With');

    require '../../config/Database.php';
    require '../../models/Quote.php';

    // Instantiate database and connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate quote object
    $quote = new Quote($db);

    // Get raw data
    $data = json_decode(file_get_contents("php://input"));

    // Makes sure quote PUT submission contains quote, id, author_id and category_id
    if(!property_exists($data, 'quote') || !property_exists($data, 'id') || !property_exists($data, 'author_id') || !property_exists($data, 'category_id')) {
        echo json_encode(array('message' => 'Missing Required Parameters'));
        return;
    }

    $quote->id = $data->id;
    $quote->quote = $data->quote;
    $quote->author_id = $data->author_id;
    $quote->category_id = $data->category_id;

    // Update quote
    if($quote->update())
        echo json_encode(array('id' => $quote->id, 'quote' => $quote->quote, 'author_id' => $quote->author_id, 'category_id' => $quote->category_id));
    else
        echo json_encode(array('message' => 'Quote Not Found'));
?>