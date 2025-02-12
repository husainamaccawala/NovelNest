<?php
class Admin {
    private $conn;
    private $table = "admin";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAdminByFullname($fullname) {
        $query = "SELECT * FROM " . $this->table . " WHERE fullname = :fullname";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':fullname', $fullname);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateLastLogin($id) {
        $query = "UPDATE " . $this->table . " SET last_login = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
