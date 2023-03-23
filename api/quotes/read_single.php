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

    // Checks if id is in url
    if(isset($_GET['id'])) {
        // Get id from url
        $quote->id = $_GET['id'];

        // Get quote
        $quote->read_single();

        if($quote->quote) {
            // Create array
            $quote_arr = array(
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author'=>$quote->author,
                'category'=>$quote->category
            );

            // Make JSON
            print_r(json_encode($quote_arr));
        } else
            print_r(json_encode(array('message' => 'No Quotes Found')));
    } else {

        // Check if author_id and category id is in url
        if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
            // Get author_id from url
            $quote->author_id = $_GET['author_id'];
            // Get category_id from url
            $quote->category_id = $_GET['category_id'];

        // Check if author_id is in url
        } else if(isset($_GET['author_id']))
            // Get author_id from url
            $quote->author_id = $_GET['author_id'];
                
        // Check if category_id is in url
        else if(isset($_GET['category_id']))
            // Get category_id from url
            $quote->category_id = $_GET['category_id'];

        // Quote query
        $result = $quote->read_single();
        // Get row count
        $num = $result->rowCount();
        
        // Check if there are any quotes
        if($num > 0) {
            // Quote array
            $quote_arr = array();
                    
            
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
            
                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author,
                    'category' => $category
                );
            
                // Push data
                array_push($quote_arr, $quote_item);
            }
        
            // Turn to JSON and output
            echo json_encode($quote_arr); 
        } else
            echo json_encode(array('message' => 'No Quotes Found'));
    }
?>