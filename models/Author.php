<?php
    class Author {
        // Variables for database
        private $conn;
        private $table = 'authors';

        // Properties of table in database
        public $id;
        public $author;

        // Constructor with database
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get authors
        public function read() {
            // Select authors query
            $query = "SELECT id, author
                    FROM {$this->table}
                    ORDER BY id";
            
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        }

        // Get single author
        public function read_single() {
            // Select query for single author
            $query = "SELECT id, author
                    FROM {$this->table}
                    WHERE id = ?";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind id
            $stmt->bindParam(1, $this->id);

            // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(is_array($row))
                // Set properties
                $this->author = $row['author'];
        }

        // Create author
        public function create() {
            // Create author query
            $query = "INSERT INTO {$this->table}
                    SET author = :author";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute()) {
                $lastId = $this->conn->lastInsertId();
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Update author
        public function update() {
            $query = "UPDATE {$this->table}
                    SET author = :author
                    WHERE id = :id";

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // Bind data
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':author', $this->author);

            // Execute query
            if($stmt->execute())
                return true;

            // Print error if something goes wrong
            printf("Error: %s. \n", $stmt->error);

            return false;
        }

        // Delete author
        public function delete() {
            // Delete query
            $query = "DELETE FROM {$this->table}
                    WHERE id = :id";

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