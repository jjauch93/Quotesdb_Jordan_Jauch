<?php
    class Quotes {
        // Variables for database
        private $conn;
        private $table = 'quotes';

        // Properties of table in database
        public $id;
        public $quote;
        public $author_id;
        public $category_id

        // Constructor with database
        public function __constructor($db) {
            $this->conn = $db;
        }

        // Get quote
        public function read() {
            $query = 'SELECT q.id, q.quote, a.author, c.category
                    FROM {$this->table} q
                    LEFT JOIN authors a ON a.id = q.author_id
                    LEFT JOIN categories c ON c.id = q.category_id
                    ORDER BY q.id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get single quote
        public function read_single() {
            if(isset($_GET['id'])) {
                $query = 'SELECT q.id, q.quote, a.author, c.category
                        FROM {$this->table} q
                        LEFT JOIN authors a ON a.id = q.author_id
                        LEFT JOIN categories c ON c.id = q.category_id
                        WHERE q.id = :id
                        LIMIT 0, 1';

                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind id
                $stmt->bindParam(':id', $this->id);

            } else if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
                $query = 'SELECT q.id, q.quote, a.author, c.category
                        FROM {$this->table} q
                        LEFT JOIN authors a ON a.id = q.author_id
                        LEFT JOIN categories c ON c.id = q.category_id
                        WHERE q.author_id = :author_id AND q.category_id = :category_id
                        LIMIT 0, 1';
                        
                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind author_id and category_id
                $stmt->bindParam(':author_id', $this->author_id);
                $stmt->bindParam(':category_id', $this->category_id);

            } else if(isset($_GET['author_id'])) {
                $query = 'SELECT q.id, q.quote, a.author, c.category
                        FROM {$this->table} q
                        LEFT JOIN authors a ON a.id = q.author_id
                        LEFT JOIN categories c ON c.id = q.category_id
                        WHERE q.author_id = :author_id
                        LIMIT 0, 1';
                        
                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind author_id
                $stmt->bindParam(':author_id', $this->author_id);

            } else if(isset($_GET['category_id'])) {
                $query = 'SELECT q.id, q.quote, a.author, c.category
                        FROM {$this->table} q
                        LEFT JOIN authors a ON a.id = q.author_id
                        LEFT JOIN categories c ON c.id = q.category_id
                        WHERE q.category_id = :category_id
                        LIMIT 0, 1';
                        
                // Prepare statement
                $stmt = $this->conn->prepare($query);

                // Bind category_id
                $stmt->bindParam(':category_id', $this->category_id);
            }

            // Execute query
            $stmt->execute();

            return $stmt;
        }
        
        // Create quote
        public function create() {
            // Query if author_id exists
            $query = "SELECT quote
                            FROM {$this->table} 
                            WHERE author_id = :author_id";
        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':author_id', $this->author_id);

            // Execute query
            if($stmt->execute()->rowCount() == 0){
                //if ($stmt->rowCount() == 0){
                    echo json_encode(array('message' => 'author_id Not Found'));
                    exit();
                //}
            }

            // Query if category_id exists
            $query = "SELECT quote
                            FROM {$this->table} 
                            WHERE category_id = :category_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()->rowCount() == 0){
                //if ($stmt->rowCount() == 0){
                    echo json_encode(array('message' => 'category_id Not Found'));
                    exit();
                //}
            }

            $query = 'INSERT INTO {$this->table}
                    SET quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute())
                return true;

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Update quote
        public function update() {
            // Query if quote_id exists
            $query = "SELECT quote
                            FROM {$this->table} 
                            WHERE quote_id = :quote_id";
        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':quote_id', $this->quote_id);

            // Execute query
            if($stmt->execute()->rowCount() == 0){
                //if ($stmt->rowCount() == 0){
                    echo json_encode(array('message' => 'quote_id Not Found'));
                    exit();
                //}
            }

            // Query if author_id exists
            $query = "SELECT quote
                            FROM {$this->table} 
                            WHERE author_id = :author_id";
        
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':author_id', $this->author_id);

            // Execute query
            if($stmt->execute()->rowCount() == 0){
                //if ($stmt->rowCount() == 0){
                    echo json_encode(array('message' => 'author_id Not Found'));
                    exit();
                //}
            }

            // Query if category_id exists
            $query = "SELECT quote
                            FROM {$this->table} 
                            WHERE category_id = :category_id";
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind data
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute()->rowCount() == 0){
                //if ($stmt->rowCount() == 0){
                    echo json_encode(array('message' => 'category_id Not Found'));
                    exit();
                //}
            }

            $query = 'UPDATE {$this->table}
                    SET quote = :quote,
                        author_id = :author_id,
                        category_id = :category_id
                    WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->quote = htmlspecialchars(strip_tags($this->quote));
            $this->author_id = htmlspecialchars(strip_tags($this->author_id));
            $this->category_id = htmlspecialchars(strip_tags($this->category_id));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':quote', $this->quote);
            $stmt->bindParam(':author_id', $this->author_id);
            $stmt->bindParam(':category_id', $this->category_id);

            // Execute query
            if($stmt->execute())
                return true;

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Delete quote
        public function delete() {
            // Delete query
            $query = 'DELETE FROM {$this->table}
                    WHERE id = :id';
            // Prepare statement
            $stmt = $this->conn->prepare($query);
        
            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
                    
            // Bind data
            $stmt->bindParam(':id', $this->id);
                    
            // Execute query
            if($stmt->execute())
                return true;
        
            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);
        
            return false;
        }
    }
?>