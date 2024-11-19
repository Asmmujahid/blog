<?php
class Database {

    private $mysqli;
    public $result = [];

    public function __construct() {
    
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'opp';

        
        $this->mysqli = new mysqli($host, $username, $password, $dbname);


        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }
    }

    public function __insert($title, $description, $image, $status) {
        $title = $this->mysqli->real_escape_string($title);
        $description = $this->mysqli->real_escape_string($description);
        $status = $this->mysqli->real_escape_string($status);
    
        $sql = "INSERT INTO posts (title, description, image, status) VALUES ('$title', '$description', '$image', '$status')";
    
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            array_push($this->result, $this->mysqli->error);
            return false;
        }

    }
    
    
    public function fetchPosts() {
        $sql = "SELECT * FROM posts";
        $result = $this->mysqli->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }


    public function fetchPostById($id) {
        $id = $this->mysqli->real_escape_string($id);
        $sql = "SELECT * FROM posts WHERE id='$id'";
        $result = $this->mysqli->query($sql);
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }


    
    }
    
    public function updatePost($id, $title, $description, $image, $status) {
        $title = $this->mysqli->real_escape_string($title);
        $description = $this->mysqli->real_escape_string($description);
        $status = $this->mysqli->real_escape_string($status);
    
        $sql = "UPDATE posts SET title='$title', description='$description', image='$image', status='$status' WHERE id='$id'";
    
        return $this->mysqli->query($sql);
    }

    public function deletePost($id) {
        $id = $this->mysqli->real_escape_string($id);
    
        
        $sql = "DELETE FROM posts WHERE id='$id'";
    
        
        return $this->mysqli->query($sql);
    }
    


    public function __destruct() {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }
}
?>
