<?php
require_once __DIR__.'/../config/DB.php';

class AudiobookClass
{
    private $db;

    public function __construct()
    {
        $this->db = new DB();
        $this->db = $this->db->connect();
    }

    public function createAudiobook($book, $narrator, $duration, $language, $audiobook)
    {
        $sql = "INSERT INTO audiobooks (book, narrator, duration, language, audiobook) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        
        if (!$stmt) {
            // Log the error and return false
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        
        $stmt->bind_param("sssss", $book, $narrator, $duration, $language, $audiobook);
        return $stmt->execute();
    }

    public function readAudiobooks()
    {
        $sql = "SELECT * FROM audiobook";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function readAudiobooksById($id)
    {
        $sql = "SELECT * FROM audiobook WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateAudiobook($id, $book, $narrator, $duration, $language, $audiobook)
    {
        $sql = "UPDATE audiobook SET book=?, narrator=?, duration=?, language=?, audiobook=? WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssssdi", $book, $narrator, $duration, $language, $audiobook, $id);
        return $stmt->execute();
    }

    public function deleteAudiobook($id)
    {
        $sql = "DELETE FROM audiobook WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
