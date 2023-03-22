<?php
    class Category {
        // Variables for database
        private $conn;
        private $table = 'categories';

        // Properties of table in database
        public $id;
        public $category;

        // Constructor with database
        public function __constructor($db) {
            $this->conn = $db;
        }

        // Get category
        public function read() {
            // Select categories query
            $query = 'SELECT id, category
                    FROM {$this->table}
                    ORDER BY id';
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get single category
        public function read_single() {
            // Select query for a single category
            $query = 'SELECT id, category
                    FROM {$this->table}
                    WHERE id = ?
                    LIMIT 0, 1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if(is_array($row)) {
                // Set properties
                $this->id = $row['id'];
                $this->author = $row['category'];
            }
        }

        // Create category
        public function create() {
            // Create category query
            $query = 'INSERT INTO {$this->table}
                    SET category = :category';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute())
                return true;

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Update category
        public function create() {
            // Update category query
            $query = 'UPDATE {$this->table}
                    SET category = :category
                    WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':category', $this->category);

            // Execute query
            if($stmt->execute())
                return true;

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Delete category
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