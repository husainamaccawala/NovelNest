<?php
$baseUrl = '/NovelNest';
require_once $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/config/DB.php';

class GenreClass
{
    private $conn;

    public function __construct()
    {
        $db = new DB();
        $this->conn = $db->connection();
    }

    // Add a new genre
    public function addGenre($name, $description)
    {
        $sql = "INSERT INTO genre (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("ss", $name, $description);
        $exe_result = $stmt->execute();

        if (!$exe_result) {
            error_log("Execute failed: " . $stmt->error);
        }

        $stmt->close();

        return $exe_result; // Return true if insertion is successful
    }


    // Update an existing genre
    public function updateGenre($id,$name, $description)
    {
        $sql = "UPDATE genre SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("ssi", $name, $description,$id); // Bind parameters: name and email are strings, id is an integer
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if update is successful, false otherwise
    }


    // Delete a genre
    public function deleteGenre($id)
    {
        $sql = "DELETE FROM genre WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        $stmt->bind_param("i", $id);
        $exe_result = $stmt->execute();
        $stmt->close();

        return $exe_result; // Return true if deletion is successful
    }

    // Get all genre
    public function getGenre()
    {
        $sql = "SELECT * FROM genre";
        $result = $this->conn->query($sql); // Execute query directly

        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Return data as an associative array
        }
        return false;
    }
}
