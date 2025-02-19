<?php
require_once __DIR__.'/../config/DB.php';

class Audiobook {
    private $db;

    public function __construct() {
        $db = new DB();
        $this->db = $db->connection();
    }

    public function getAllAudiobooks() {
        $query = "SELECT a.*, b.title AS book_name 
                 FROM audiobooks a 
                 LEFT JOIN books b ON a.book_id = b.id";
        $result = $this->db->query($query);
        if (!$result) {
            return false;
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAudiobookById($id) {
        $query = "SELECT a.*, b.title AS book_name 
                 FROM audiobooks a 
                 LEFT JOIN books b ON a.book_id = b.id 
                 WHERE a.id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function addAudiobook($data) {
        $query = "INSERT INTO audiobooks (book_id, description, narrator, file, name)
                 VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("issss",
            $data['book_id'],
            $data['description'],
            $data['narrator'],
            $data['file'],
            $data['name']  // Add the name field
        );
        return $stmt->execute();
    }

    public function updateAudiobook($data) {
        $query = "UPDATE audiobooks
                 SET book_id = ?, description = ?, narrator = ?, name = ?" .  // Add the name field
                 ($data['file'] ? ", file = ?" : "") .
                 " WHERE id = ?";
    
        $stmt = $this->db->prepare($query);
    
        if ($data['file']) {
            $stmt->bind_param("issssi",
                $data['book_id'],
                $data['description'],
                $data['narrator'],
                $data['name'],  // Add the name field
                $data['file'],
                $data['id']
            );
        } else {
            $stmt->bind_param("isssi",
                $data['book_id'],
                $data['description'],
                $data['narrator'],
                $data['name'],  // Add the name field
                $data['id']
            );
        }
    
        return $stmt->execute();
    }

    public function deleteAudiobook($id) {
        $query = "DELETE FROM audiobooks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>

